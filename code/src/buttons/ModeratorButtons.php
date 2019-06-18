<?php
/**
 * Created by PhpStorm.
 * User: fedornabilkin
 * Date: 08.06.2019
 * Time: 16:35
 */

namespace Fp\Telebot\buttons;


use Fp\Telebot\Dictionary as D;
use unreal4u\TelegramAPI\Telegram\Types\ReplyKeyboardMarkup;

class ModeratorButtons extends GuestButtons
{

    /**
     * @inheritdoc
     */
    public function create(): void
    {
        parent::create();

        $buttons = [
            D::BTN_USER_LIST,
        ];

        $this->buttons = array_merge($this->buttons, $buttons);
    }

    /**
     * @return ReplyKeyboardMarkup
     */
    public function getCompleteMarkup()
    {
        $m = parent::getCompleteMarkup();
//        $m->text = D::BTN_MODERATOR_PANEL;
        return $m;
    }
}