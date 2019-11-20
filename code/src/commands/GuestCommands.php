<?php

namespace Fp\Telebot\commands;

use Fp\Telebot\Dictionary as D;

/**
 * Class GuestCommands
 * @package Fp\Telebot\commands
 */
class GuestCommands extends AbstractCommands
{
    /**
     * @inheritDoc
     */
    public function getCommandsCallback()
    {
        return [
            D::CALLBACK_NOTES_PANEL => [$this->getHandler(), 'initNotifyDayPanel'],
            D::CALLBACK_TIME_PANEL => [$this->getHandler(), 'initNotifyTimePanel'],
            D::CALLBACK_NOTES_TOGGLE => [$this->getHandler(), 'toggleNote'],
            D::CALLBACK_NOTES_REMOVE => [$this->getHandler(), 'removeNote'],
            D::CALLBACK_NOTIFY_CLEAR => [$this->getHandler(), 'notifyClear'],
            D::CALLBACK_NOTIFY_ADD_DAY => [$this->getHandler(), 'addDayNotify'],
            D::CALLBACK_NOTIFY_ADD_TIME => [$this->getHandler(), 'addTimeNotify'],
        ];
    }

    /**
     * @inheritDoc
     */
    public function getCommandsCmd()
    {
        return [
            D::CMD_START => [$this->getHandler(), 'getHelp'],
            D::CMD_HELP => [$this->getHandler(), 'getHelp'],
            D::CMD_ADD => [$this->getHandler(), 'addNotes'],
        ];
    }

    /**
     * @inheritDoc
     */
    public function getCommandsText()
    {
        return [
            '?' => [$this->getHandler(), 'getHelp'],
            D::T_UK => [$this->getHandler(), 'infoUk'],
            D::T_TAXI => [$this->getHandler(), 'infoTaxi'],
            D::T_APTEKA => [$this->getHandler(), 'infoApteka'],
            D::T_NOTES => [$this->getHandler(), 'notesList'],
        ];
    }
}
