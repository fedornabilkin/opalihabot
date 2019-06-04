<?php


namespace Fp\Telebot\commands;


use Fp\Telebot\handlers\GuestHandler;

/**
 * Class GuestCommands
 * @package Fp\Telebot\commands
 */
class GuestCommands extends AbstractCommands
{
    public function __construct()
    {
        $this->setHandler(new GuestHandler());
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
        return [];
    }

    /**
     * @inheritDoc
     */
    public function getCommandsText()
    {
        return [];
    }
}
