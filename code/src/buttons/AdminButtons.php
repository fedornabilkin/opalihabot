<?php


namespace Fp\Telebot\buttons;


use Fp\Telebot\Dictionary as D;
use unreal4u\TelegramAPI\Telegram\Methods\SendMessage;

/**
 * Class AdminButtons
 * @package Fp\Telebot\buttons
 */
class AdminButtons extends AbstractButtons
{
    /**
     * @inheritDoc
     */
    public function create()
    {
        $buttons = [
            D::BTN_SALES_PANEL,
            D::BTN_USER_LIST,
            D::BTN_PAST_FACT_MAILING,
            D::BTN_PAST_FACT_MAILING_RB,
            D::BTN_PAST_FACT_MAILING_LV
        ];

        $this->addButtons($buttons);
    }

    /**
     * @return SendMessage
     */
    public function getSendMessage(): SendMessage
    {
        $m = parent::getSendMessage();
        $m->text = D::BTN_ADMIN_PANEL;
        return $m;
    }
}
