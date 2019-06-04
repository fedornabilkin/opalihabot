<?php


namespace Fp\Telebot;

use Fp\Telebot\Dictionary as D;
use Fp\Telebot\helpers\ConsoleHelper;
use Fp\Telebot\models\UserModel;
use React\EventLoop\Factory;
use unreal4u\TelegramAPI\HttpClientRequestHandler;
use unreal4u\TelegramAPI\Telegram\Methods\SendChatAction;
use unreal4u\TelegramAPI\Telegram\Methods\SendMessage;
use unreal4u\TelegramAPI\Telegram\Methods\SendPhoto;
use unreal4u\TelegramAPI\Telegram\Types\Custom\InputFile;
use unreal4u\TelegramAPI\TgLog;

/**
 * Class Sender
 * @package Fp\Telebot
 */
class Sender
{

    public $loop;
    /** @var TgLog */
    public $tgLog;

    public function __construct($tgLog, $loop)
    {
        $this->tgLog = $tgLog;
        $this->loop = $loop;
    }

    public function sendOnlineSalesToAdmins()
    {
        $path = D::IMG_REVENUE;
        // Отправим пост-запрос для обновления картинки
        file_get_contents(WKHTML_URL, false, stream_context_create(['http' => ['method' => 'POST', 'header' => "Content-Type: text/plain\r\nContent-Length: 0\r\n"]]));
        sleep(3);

        file_put_contents($path, file_get_contents(WKHTML_URL));

        $chatIds = (new UserModel())->getAdminsChatIds();
        foreach ($chatIds as $chatId) {
            $loop = Factory::create();
            $tgLog = new TgLog(BOT_TOKEN, new HttpClientRequestHandler($loop));

            $sendPhoto = new SendPhoto();
            $sendPhoto->chat_id = $chatId;
            $sendPhoto->photo = new InputFile($path);

            $tgLog->performApiRequest($sendPhoto);

            $loop->run();
        }
    }

    /**
     * @param $method
     */
    public function send($method)
    {
        $this->tgLog->performApiRequest($method);
    }

    /**
     * @param string $text
     * @param integer $chatId
     * @param string $parseMode
     *
     * @deprecated
     */
    public function sendMessage($text, $chatId, $parseMode)
    {
        $this->consoleLog('Method is deprecated');
        $this->consoleLog(__METHOD__);
        $this->consoleLog(__FILE__ . ':' . __LINE__);

        $action = new SendChatAction();
        $action->action = "typing";
        $action->chat_id = $chatId;

        $this->tgLog->performApiRequest($action)->then(
            function () use ($text, $parseMode, $chatId) {

                $sendMessage = new SendMessage();

                $sendMessage->parse_mode = $parseMode;
                $sendMessage->chat_id = $chatId;
                $sendMessage->text = $this->filterText($text);

                $this->send($sendMessage);
            }
        );
    }

    /**
     * @param string $text
     * @return string
     *
     * @deprecated
     */
    protected function filterText($text)
    {
        return str_replace("_", "\\_", $text);
    }

    protected function consoleLog($text)
    {
        ConsoleHelper::consoleLog($text);
    }
}
