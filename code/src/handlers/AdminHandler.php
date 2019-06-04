<?php


namespace Fp\Telebot\handlers;


use Fp\Telebot\buttons\AdminButtons;
use Fp\Telebot\buttons\SaleButtons;
use Fp\Telebot\Dictionary as D;
use Fp\Telebot\models\RoleModel;
use Fp\Telebot\models\RoleUserModel;
use Fp\Telebot\models\UserModel;
use Fp\Telebot\panels\AssignRolePanel;
use Fp\Telebot\panels\UserListPanel;

/**
 * Class AdminHandler
 * @package Fp\Telebot\handlers
 *
 *
 */
class AdminHandler extends AbstractHandler
{

    public function __construct()
    {
        $this->consoleLog(self::class);
    }

    /**
     * Формирует панель для управления ролями пользователя
     */
    public function initAssignRolePanel()
    {
        $user = (new UserModel())->getRow($this->callbackQueryData['userId']);

        $this->callbackQueryData["chatId"] = $this->message->chat->id;
        $this->callbackQueryData['user'] = $user;

        $panel = new AssignRolePanel();
        $panel->params = $this->callbackQueryData;

        $this->pushMethod($panel->getSendMessage());
    }

    /**
     * Формирует панель в виде списка пользователей
     */
    public function initUserListPanel()
    {
        $users = (new UserModel())->getUsersWithRole();

        $panel = new UserListPanel();
        $panel->setUsers($users);

        $this->pushMethod($panel->getSendMessage());
    }

    /**
     * Формирует быстрые кнопки для админа
     */
    public function initAdminButtons()
    {
        $buttons = new AdminButtons();
        $this->pushMethod($buttons->getSendMessage());
    }

    /**
     * ФОрмирует быстрые кнопки для продаж
     */
    public function initQvButtons()
    {
        $buttons = new SaleButtons();
        $buttons->setIsAdmin(true);
        $this->pushMethod($buttons->getSendMessage());
    }

    /**
     * Устанавливает роль пользователю и отправляет результат выполнения
     */
    public function processAssignRole()
    {
        // сменить роль
        $user = (new UserModel())->getRow($this->callbackQueryData['userId']);
        $role = (new RoleModel())->getRow($this->callbackQueryData['roleId']);

        if ($this->isCurrentUser($user["chatid"]) || !$this->assignRole($this->callbackQueryData)) {
            $this->pushMethod($this->getErrorMethod());
        } else {
            // уведомить юзера и админа
            $m[] = $this->setMethodMessage(D::MSG_ROLE_CHANGE . ' ' . $role['role'], $this->message->chat->id);
            $m[] = $this->setMethodMessage(D::MSG_ROLE_CHANGE_USER . ' ' . $role['role'], $user["chatid"]);
            $this->pushMethod($m);
        }

    }

    /**
     * @return void
     */
    public function sendToNotGuest()
    {
        $userModel = new UserModel();
        $chatIds = array_merge($userModel->getAdminsChatIds(), $userModel->getQvChatIds());
        $text = $this->getPastFactContent($this->message->text);

        $m = $this->setMethodMultipleChats($text, $chatIds);
        $this->pushMethod($m);
    }

    /**
     * @param int $chatId
     * @return bool
     */
    protected function isCurrentUser($chatId)
    {
        return $chatId === $this->message->chat->id;
    }

    /**
     * @param array $data
     * @return int
     */
    protected function assignRole(array $data)
    {
        return (new RoleUserModel())->assignRole($data['userId'], $data['roleId']);
    }
}
