<?php

namespace Fp\Telebot\commands;

use Fp\Telebot\Dictionary as D;

/**
 * Class AdminCommands
 * @package Fp\Telebot\commands
 */
class AdminCommands extends ModeratorCommands
{
    /**
     * @inheritDoc
     */
    public function getCommandsCallback()
    {
        $arr = parent::getCommandsCallback();

        return array_merge($arr, [
            D::CALLBACK_USERS_PANEL => [$this->getHandler(), 'initAssignRolePanel'],
            D::CALLBACK_ROLES_PANEL => [$this->getHandler(), 'processAssignRole'],
        ]);
    }

    /**
     * @inheritDoc
     */
    public function getCommandsCmd()
    {
        $arr = parent::getCommandsCmd();

        return array_merge($arr, [

        ]);
    }

    /**
     * @inheritDoc
     */
    public function getCommandsText()
    {
        $arr = parent::getCommandsText();

        return array_merge($arr, [
            D::BTN_LAST_CMD_LIST => [$this->getHandler(), 'lastCmdList'],
            'test' => [$this->getHandler(), 'test'],
        ]);
    }

}
