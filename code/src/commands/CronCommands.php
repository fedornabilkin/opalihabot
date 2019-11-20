<?php

namespace Fp\Telebot\commands;


/**
 * Class CronCommands
 * @package Fp\Telebot\commands
 */
class CronCommands extends AbstractCommands
{
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
        return [];
    }

    /**
     * @inheritDoc
     */
    public function getCommandsText()
    {
        return [
            'filed' => [$this->getHandler(), 'sendFileFiled'],
            'updated' => [$this->getHandler(), 'sendFileUpdate'],
            'monitoring' => [$this->getHandler(), 'sendMonitoring'],

            'user' => [$this->getHandler(), 'sendUser'],
            'group' => [$this->getHandler(), 'sendGroup'],
            'ipu' => [$this->getHandler(), 'sendIpu'],
            'notify' => [$this->getHandler(), 'sendNotifyAll'],
        ];
    }
}
