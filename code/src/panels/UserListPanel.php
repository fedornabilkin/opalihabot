<?php


namespace Fp\Telebot\panels;


use Fp\Telebot\Dictionary as D;

/**
 * Class UserListPanel
 * @package Fp\Telebot\panels
 */
class UserListPanel extends AbstractPanel
{
    protected $rows;

    /**
     * @param array $rows
     */
    public function setRows($rows): void
    {
        $this->rows = $rows;
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

        foreach ($this->rows as $key => $row) {
            $userName = $row["username"] ? '@' . $row["username"] : 'None';

            $text = sprintf($tmp, $row["id"], $row["fullname"], $userName, $row["role"]);

            $callback[D::CALLBACK_PM_ACTION] = D::CALLBACK_USERS_PANEL;
            $callback['userId'] = $row["id"];
            $callback['roleId'] = $row["roleid"];

            $this->addInlineButton($text, $key, $this->callbackPrepare($callback));
        }
    }
}
