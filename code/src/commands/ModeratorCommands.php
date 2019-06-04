<?php


namespace Fp\Telebot\commands;


use Fp\Telebot\Dictionary as D;
use Fp\Telebot\handlers\ModeratorHandler;

/**
 * Class QvCommands
 * @package Fp\Telebot\commands
 */
class ModeratorCommands extends AbstractCommands
{
    public function __construct()
    {
        $this->setHandler(new ModeratorHandler());
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
            D::CMD_START => [$this->getHandler(), 'initModeratorButtons']
        ];
    }

    /**
     * @inheritDoc
     */
    public function getCommandsText()
    {
        return [
            'qwerty' => [$this->getHandler(), 'getRevenue'],
        ];
    }
}
