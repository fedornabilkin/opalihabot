<?php


namespace Fp\Telebot\buttons;


use Fp\Telebot\Dictionary as D;
use unreal4u\TelegramAPI\Telegram\Methods\SendMessage;

/**
 * Class SaleButtons
 * @package Fp\Telebot\buttons
 */
class SaleButtons extends AbstractButtons
{
    protected $isAdmin;


    /**
     * @param bool $isAdmin
     */
    public function setIsAdmin($isAdmin): void
    {
        $this->isAdmin = $isAdmin;
    }

    /**
     * @inheritDoc
     */
    public function create()
    {
        $buttons = [
            D::BTN_SALES_ONLINE,
            D::BTN_PAST_FACT,
            D::BTN_PAST_FACT_RB,
            D::BTN_PAST_FACT_LV
        ];

        if ($this->isAdmin) {
            array_unshift($buttons, D::BTN_ADMIN_PANEL);
        }

        $this->addButtons($buttons);
    }

    /**
     * @return SendMessage
     */
    public function getSendMessage(): SendMessage
    {
        $m = parent::getSendMessage();
        $m->text = D::BTN_SALES_ONLINE;
        return $m;
    }
}
