<?php


namespace Fp\Telebot\handlers;


use Fp\Telebot\buttons\ModeratorButtons;
use Fp\Telebot\models\UserModel;
use Fp\Telebot\panels\UserListPanel;

/**
 * Class QvHandler
 * @package Fp\Telebot\handlers
 */
class ModeratorHandler extends GuestHandler
{
    /**
     * Формирует панель в виде списка пользователей
     */
    public function initUserListPanel()
    {
        $users = (new UserModel())->getUsersWithRole();

        $panel = new UserListPanel();
        $panel->setRows($users);

        $this->pushMethod($panel->getSendMessage());
    }
}
