<?php


namespace Fp\Telebot\panels;


use Fp\Telebot\Dictionary as D;

/**
 * Class UserListPanel
 * @package Fp\Telebot\panels
 */
class UserListPanel extends AbstractPanel
{
    protected $users;

    /**
     * @param array $users
     */
    public function setUsers($users): void
    {
        $this->users = $users;
    }

    /**
     * @inheritDoc
     */
    public function getSendMessage()
    {
        $m = parent::getSendMessage();
        $m->text = D::PANEL_USER_LIST;
        return $m;
    }

    public function create()
    {

        $tmp = "%s. %s - %s %s";

        foreach ($this->users as $key => $user) {
            $userName = $user["username"] ? '@' . $user["username"] : 'None';

            $text = sprintf($tmp, $user["id"], $user["fullname"], $userName, $user["role"]);

            $callback[D::CALLBACK_PM_ACTION] = D::CALLBACK_USERS_PANEL;
            $callback['userId'] = $user["id"];
            $callback['roleId'] = $user["roleid"];

            $this->addInlineButton($text, $key, $this->callbackPrepare($callback));
        }
    }
}
