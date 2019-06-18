<?php
/**
 * Created by PhpStorm.
 * User: fedornabilkin
 * Date: 08.06.2019
 * Time: 16:30
 */

namespace Fp\Telebot\buttons;


use Fp\Telebot\Dictionary as D;
use unreal4u\TelegramAPI\Telegram\Types\ReplyKeyboardMarkup;

class GuestButtons extends AbstractButtons
{
    /**
     * @inheritdoc
     */
    public function create(): void
    {
        $buttons = [
            '?',
            D::T_UK,
            D::T_TAXI,
            D::T_APTEKA,
            D::T_NOTES,
        ];

        $this->buttons = array_merge($this->buttons, $buttons);
    }

    /**
     * @return ReplyKeyboardMarkup
     */
    public function getCompleteMarkup()
    {
        $m = parent::getCompleteMarkup();
//        $m->text = D::BTN_USER_PANEL;
        return $m;
    }
}