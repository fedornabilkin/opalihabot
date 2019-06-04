<?php


namespace Fp\Telebot\buttons;


use unreal4u\TelegramAPI\Telegram\Methods\SendMessage;
use unreal4u\TelegramAPI\Telegram\Types\KeyboardButton;
use unreal4u\TelegramAPI\Telegram\Types\ReplyKeyboardMarkup;

/**
 * Class AbstractButtons
 *
 * Чтобы создать панель с кнопками, необходимо создать класс-наследник AbstractButtons.
 * Реализовать метод create(), в котором сформировать список кнопок.
 * Метод create() вызывается при получении объекта SendMessage в методе getSendMessage().
 *
 * $buttons = new AdminButtons();
 * $m = $buttons->getSendMessage();
 * $tgLog->performApiRequest($m);
 *
 * @package Fp\Telebot\buttons
 */
abstract class AbstractButtons
{

    protected $sendMessage;
    protected $markup;

    public function __construct()
    {
        $this->markup = new ReplyKeyboardMarkup();
        $this->sendMessage = new SendMessage();
    }

    /**
     * В этом методе выполняем все необходимые действия, чтобы сформировать кнопки
     * Метод будет вызван при запросе объекта сообщения
     *
     * @see getSendMessage
     * @return void
     */
    abstract public function create();

    /**
     * @return SendMessage
     */
    public function getSendMessage()
    {
        $this->create();
        $this->sendMessage->reply_markup = $this->getMarkup();

        return $this->sendMessage;
    }

    /**
     * @return ReplyKeyboardMarkup
     * @see getSendMessage
     */
    protected function getMarkup()
    {
        $this->markup->resize_keyboard = true;
        return $this->markup;
    }

    /**
     * @param array $buttons
     */
    protected function addButtons(array $buttons)
    {
        foreach ($buttons as $key => $name) {
            $stage = ($key >= 2) ? 2 : 1;
            $this->addButton($name, $stage);
        }
    }

    /**
     * @param string $text
     * @param int $stage
     */
    protected function addButton($text, $stage = 1)
    {
        $this->markup->keyboard[$stage][] = $this->setKeyBoardButton($text);
    }

    /**
     * @param $text
     * @return KeyboardButton
     */
    protected function setKeyBoardButton($text)
    {
        $button = new KeyboardButton();
        $button->text = $text;
        return $button;
    }
}
