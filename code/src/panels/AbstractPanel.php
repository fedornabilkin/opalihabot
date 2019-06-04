<?php


namespace Fp\Telebot\panels;


use Fp\Telebot\helpers\CallbackHelper;
use unreal4u\TelegramAPI\Telegram\Methods\SendMessage;
use unreal4u\TelegramAPI\Telegram\Types\Inline\Keyboard\Button;
use unreal4u\TelegramAPI\Telegram\Types\Inline\Keyboard\Markup;

/**
 * Class AbstractPanel
 *
 * Чтобы создать панель с кнопками под сообщением, необходимо создать класс-наследник AbstractPanel.
 * Реализовать метод create(), в котором сформировать список кнопок с данными для callback.
 * Метод create() вызывается при получении объекта SendMessage в методе getSendMessage().
 *
 * $panel = new UserListPanel();
 * $panel->setUsers($users);
 * $m = $panel->getSendMessage();
 * $tgLog->performApiRequest($m);
 *
 * @package Fp\Telebot\panels
 */
abstract class AbstractPanel
{
    protected $sendMessage;
    protected $markup;

    public function __construct()
    {
        $this->markup = new Markup();
        $this->sendMessage = new SendMessage();
    }

    /**
     * В данном методе производим все необходимые действия для формирования кнопок
     * Метод будет вызван при запросе объекта сообщения
     *
     * @see getSendMessage
     * @return void
     */
    abstract public function create();

    /**
     * Устанавливает параметры и возвращает объект сообщения.
     * В дочерних классах переопределяем, чтобы задать текст сообщения.
     *
     * @return SendMessage
     */
    public function getSendMessage()
    {
        $this->create();

        $this->sendMessage->disable_web_page_preview = true;
        $this->sendMessage->parse_mode = 'Markdown';
        $this->sendMessage->reply_markup = $this->getMarkup();

        return $this->sendMessage;
    }

    /**
     * @return Markup
     * @see getSendMessage
     */
    protected function getMarkup()
    {
        return $this->markup;
    }

    /**
     * @param string $text
     * @param int $stage
     * @param string $callBackData
     */
    protected function addInlineButton($text, $stage = 1, $callBackData = '')
    {
        $this->markup->inline_keyboard[$stage][] = $this->setInlineButton($text, $callBackData);
    }

    /**
     * @param string $text
     * @param string $callBackData
     * @return Button
     */
    protected function setInlineButton($text, $callBackData)
    {
        $button = new Button();
        $button->text = (string)$text;
        $button->callback_data = (string)$callBackData;
        return $button;
    }

    /**
     * @param array $data
     * @return string
     */
    protected function callbackPrepare($data)
    {
        return CallbackHelper::prepare($data);
    }
}
