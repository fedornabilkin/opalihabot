<?php


namespace Fp\Telebot\commands;


use Fp\Telebot\Dictionary as D;
use Fp\Telebot\handlers\AdminHandler;

/**
 * Class AdminCommands
 * @package Fp\Telebot\commands
 */
class AdminCommands extends AbstractCommands
{
    public function __construct()
    {
        $this->setHandler(new AdminHandler());
    }

    /**
     * @inheritDoc
     */
    public function getCommandsCallback()
    {
        return [
            D::CALLBACK_USERS_PANEL => [$this->getHandler(), 'initAssignRolePanel'],
            D::CALLBACK_ROLES_PANEL => [$this->getHandler(), 'processAssignRole']
        ];
    }

    /**
     * @inheritDoc
     */
    public function getCommandsCmd()
    {
        return [
            D::CMD_START => [$this->getHandler(), 'initAdminButtons']
        ];
    }

    /**
     * @inheritDoc
     */
    public function getCommandsText()
    {
        return [
            D::BTN_ADMIN_PANEL => [$this->getHandler(), 'initAdminButtons'],
            D::BTN_SALES_PANEL => [$this->getHandler(), 'initQvButtons'],
            D::BTN_USER_LIST => [$this->getHandler(), 'initUserListPanel'],

            D::BTN_PAST_FACT => [$this->getHandler(), 'sendPastFactContent'],
            D::BTN_PAST_FACT_RB => [$this->getHandler(), 'sendPastFactContent'],
            D::BTN_PAST_FACT_LV => [$this->getHandler(), 'sendPastFactContent'],

            D::BTN_PAST_FACT_MAILING => [$this->getHandler(), 'sendToNotGuest'],
            D::BTN_PAST_FACT_MAILING_RB => [$this->getHandler(), 'sendToNotGuest'],
            D::BTN_PAST_FACT_MAILING_LV => [$this->getHandler(), 'sendToNotGuest'],

            D::BTN_SALES_ONLINE => [$this->getHandler(), 'getRevenue'],
        ];
    }

}
