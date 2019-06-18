<?php


namespace Fp\Telebot\commands;


use Fp\Telebot\Dictionary as D;
use Fp\Telebot\handlers\ModeratorHandler;

/**
 * Class QvCommands
 * @package Fp\Telebot\commands
 */
class ModeratorCommands extends GuestCommands
{
    public function __construct()
    {
        parent::__construct();
        $this->setHandler(new ModeratorHandler());
    }

    /**
     * @inheritDoc
     */
    public function getCommandsCallback()
    {
        $arr = parent::getCommandsCallback();

        return array_merge($arr, [

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
            'qwerty' => [$this->getHandler(), 'getRevenue'],
            D::BTN_USER_LIST => [$this->getHandler(), 'initUserListPanel'],
        ]);
    }
}
