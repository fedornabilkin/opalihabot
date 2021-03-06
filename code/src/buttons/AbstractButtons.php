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

//    protected $sendMessage;
    protected $markup;
    protected $buttons = [];

    public function __construct()
    {
        $this->markup = new ReplyKeyboardMarkup();
//        $this->sendMessage = new SendMessage();
    }

    /**
     * В этом методе выполняем все необходимые действия, чтобы сформировать кнопки
     * Метод будет вызван при запросе объекта сообщения
     *
     * @see getCompleteMarkup
     * @return void
     */
    abstract public function create(): void ;

    /**
     * @return ReplyKeyboardMarkup
     */
    public function getCompleteMarkup()
    {
        return $this->getMarkup();
//        $this->sendMessage->reply_markup = $this->getMarkup();
////        $this->sendMessage->text = '*';
////
////        return $this->sendMessage;
    }

    /**
     * @return ReplyKeyboardMarkup
     * @see getCompleteMarkup
     */
    protected function getMarkup()
    {
        $this->create();
        $this->addButtons($this->buttons);

        $this->markup->resize_keyboard = true;
        return $this->markup;
    }

    /**
     * @param array $buttons
     */
    protected function addButtons(array $buttons)
    {
        foreach ($buttons as $key => $name) {
            $stage = ($key >= 5) ? 2 : 1;
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
