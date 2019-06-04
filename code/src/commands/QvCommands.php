<?php


namespace Fp\Telebot\commands;


use Fp\Telebot\Dictionary as D;
use Fp\Telebot\handlers\QvHandler;

/**
 * Class QvCommands
 * @package Fp\Telebot\commands
 */
class QvCommands extends AbstractCommands
{
    public function __construct()
    {
        $this->setHandler(new QvHandler());
    }

    /**
     * @inheritDoc
     */
    public function getCommandsCallback()
    {
        return [];
    }

    /**
     * @inheritDoc
     */
    public function getCommandsCmd()
    {
        return [
            D::CMD_START => [$this->getHandler(), 'initQvButtons']
        ];
    }

    /**
     * @inheritDoc
     */
    public function getCommandsText()
    {
        return [
            D::BTN_PAST_FACT => [$this->getHandler(), 'sendPastFactContent'],
            D::BTN_PAST_FACT_RB => [$this->getHandler(), 'sendPastFactContent'],
            D::BTN_PAST_FACT_LV => [$this->getHandler(), 'sendPastFactContent'],

            D::BTN_SALES_ONLINE => [$this->getHandler(), 'getRevenue'],
        ];
    }
}
