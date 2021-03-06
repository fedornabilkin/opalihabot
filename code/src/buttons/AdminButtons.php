<?php


namespace Fp\Telebot\buttons;


use Fp\Telebot\Dictionary as D;
use unreal4u\TelegramAPI\Telegram\Types\ReplyKeyboardMarkup;

/**
 * Class AdminButtons
 * @package Fp\Telebot\buttons
 */
class AdminButtons extends ModeratorButtons
{
    /**
     * @inheritDoc
     */
    public function create(): void
    {
        parent::create();

        $buttons = [
            D::BTN_LAST_CMD_LIST,
        ];

        $this->buttons = array_merge($this->buttons, $buttons);
    }

    /**
     * @return ReplyKeyboardMarkup
     */
    public function getCompleteMarkup()
    {
        $m = parent::getCompleteMarkup();
//        $m->text = D::BTN_ADMIN_PANEL;
        return $m;
    }
}
