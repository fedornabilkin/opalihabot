<?php


namespace Fp\Telebot\handlers;


use Fp\Telebot\buttons\AbstractButtons;
use Fp\Telebot\Dictionary as D;
use Fp\Telebot\helpers\CalendarHelper;
use Fp\Telebot\helpers\CallbackHelper;
use Fp\Telebot\helpers\ConsoleHelper;
use Fp\Telebot\RequestData;
use Fp\Telebot\Sender;
use React\HttpClient\Client;
use unreal4u\TelegramAPI\Abstracts\TelegramMethods;
use unreal4u\TelegramAPI\Interfaces\TelegramMethodDefinitions;
use unreal4u\TelegramAPI\Telegram\Methods\SendChatAction;
use unreal4u\TelegramAPI\Telegram\Methods\SendMessage;
use unreal4u\TelegramAPI\Telegram\Methods\SendPhoto;
use unreal4u\TelegramAPI\Telegram\Types\Custom\InputFile;
use function array_unique;
use function is_array;

/**
 * Class AbstractHandler
 * @package Fp\Telebot\handlers
 */
abstract class AbstractHandler
{
    public $loop;
    public $TgLog;
    public $arguments;

    protected $callbackQueryData;
    protected $message;

    protected $isCallback = false;
    protected $isCommand = false;
    protected $isCron = false;

    /** @var AbstractButtons */
    protected $buttons;

    protected $methods = [];
    /** @var CalendarHelper */
    protected $calendar;

    public function __construct()
    {
        $this->calendar = new CalendarHelper();
    }

    /**
     * @param RequestData $data
     */
    public function setData($data)
    {
        $this->consoleLog('set data in handler');

        $this->loop = $data->getLoop();
        $this->TgLog = $data->getTgLog();
        $this->isCron = $data->getIsCron();
        $this->isCallback = $data->getIsCallback();
        $this->isCommand = $data->getIsCommand();
        $this->callbackQueryData = CallbackHelper::parse($data->getText());
        $this->message = $data->getMessage();
        $this->arguments = $data->getArguments();
    }

    protected function setInstanceButtons($buttons)
    {
        if(!$this->buttons){
            $this->buttons = $buttons;
        }
    }

    /**
     * @param TelegramMethodDefinitions|array $method
     */
    protected function pushMethod($method)
    {
        if (!is_array($method)) {
            $method = [$method];
        }

        $this->methods = array_merge($this->methods, $method);
    }

    /**
     * Добавляет в массив методы с одним сообщением для нескольких чатов
     *
     * @param string $text
     * @param array $chatIds
     * @param string $parseMode
     * @return array
     */
    protected function setMethodMultipleChats($text, array $chatIds, $parseMode = 'Markdown')
    {
        $methods = [];
        $Ids = array_unique($chatIds);
        foreach ($Ids as $chatId) {
            $methods[] = $this->setMethodMessage($text, $chatId, $parseMode);
        }

        return $methods;
    }

    /**
     * Добавляет в массив методы всех сообщений для всех чатов
     *
     * @param array $messages
     * @param array $chatIds
     */
    protected function setMultipleMessagesMultipleChats(array $messages, array $chatIds)
    {
        foreach ($messages as $text) {
            $m = $this->setMethodMultipleChats($text, $chatIds);
            $this->pushMethod($m);
        }
    }

    /**
     * Создает объект простого сообщения
     *
     * @param string $text
     * @param int $chatId
     * @param string $parseMode
     * @return TelegramMethodDefinitions
     */
    protected function setMethodMessage($text, $chatId, $parseMode = 'Markdown')
    {
        $m = $this->createMethod();

        $m->parse_mode = $parseMode;
        $m->chat_id = $chatId;
        $m->text = $text;

        return $m;
    }

    /**
     * @return TelegramMethodDefinitions
     */
    protected function setMethodAction()
    {
        $m = $this->createMethod(new SendChatAction());
        $m->action = "upload_photo";
        return $m;
    }

    /**
     * Создает обехкт для отправки фото
     *
     * @param string $path
     * @param int $chatId
     * @return TelegramMethodDefinitions
     */
    protected function setMethodPhoto($path, $chatId)
    {
        $m = $this->createMethod(new SendPhoto());
        $m->photo = new InputFile($path);
        $m->chat_id = $chatId;
        return $m;
    }

    /**
     * Возвращает стандартное сообщение о неизвестной ошибке
     * @return TelegramMethodDefinitions
     */
    protected function getErrorMethod()
    {
        return $this->setMethodMessage(D::MSG_ERROR, $this->message->chat->id);
    }

    /**
     * @param TelegramMethodDefinitions|null $method
     * @return TelegramMethodDefinitions
     */
    protected function createMethod(TelegramMethodDefinitions $method = null): TelegramMethodDefinitions
    {
        return $method ?? new SendMessage();
    }

    /**
     * Сообщение с помощью по управлению ботов
     */
    public function getHelp()
    {
        $text = "
        *Помощь.*
        /start - начало работы, инициализация панели управления
        /help - помощь, также можно отправить \"?\"
        /add текст - _добавить запись_
        ";

        $m[] = $this->setMethodMessage($text, $this->message->chat->id);
        $this->pushMethod($m);
    }

    public function getRevenue()
    {
        $client = new Client($this->loop);
        $this->pushMethod($this->setMethodAction());

        $request = $client->request('POST', WKHTML_URL, [
            'Content-Type' => 'text/plain',
            'Content-Length' => 0
        ]);

        $request->on('response', function ($response) {
            $response->on('end', function () {

                $path = D::IMG_REVENUE;
                file_put_contents($path, file_get_contents(WKHTML_URL));
                $methods = $this->setMethodPhoto($path, $this->message->chat->id);
                $this->send($methods);
            });
        });

        $request->on("error", function ($e) {
        });
        $request->end();
    }

    /**
     * !!! Использовать только для отправки сообщений в промисах, когда основной код выполнился,
     * а ответ от сервера еще не пришел
     *
     * Для обычной отправки сообщений объект сообщения добавляем в массив $this->methods
     * @param TelegramMethods $methods
     * @see pushMethod
     *
     */
    private function send($methods)
    {
        (new Sender($this->TgLog, $this->loop))->send($methods);
    }

    /**
     * Возвращает массив методов для отправки в чаты
     * @return array
     */
    public function getMethods(): array
    {
        $this->refreshSpeedButtons();
        return $this->methods;
    }

    /**
     * Если в сообщении не определен reply_markup, то обновляем быстрые кнопки
     */
    protected function refreshSpeedButtons(): void
    {
        if(!isset($this->buttons)){
            return;
        }

        foreach ($this->methods as $key => $method){
            if(!$this->methods[$key]->reply_markup && $this->isMessageThisChat($method)){
                $this->methods[$key]->reply_markup = $this->buttons->getCompleteMarkup();
                break;
            }
        }
    }

    /**
     * @param $method
     * @return bool
     */
    protected function isMessageThisChat($method): bool
    {
        return !$method->chat_id || $method->chat_id === $this->message->chat->id;
    }

    /**
     * @param string|array|object $text
     */
    protected function consoleLog($text)
    {
        ConsoleHelper::consoleLog($text);
    }
}
