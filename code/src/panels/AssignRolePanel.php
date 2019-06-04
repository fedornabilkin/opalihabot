<?php


namespace Fp\Telebot\panels;


use Fp\Telebot\Dictionary as D;

/**
 * Class AssignRolePanel
 * @package Fp\Telebot\panels
 */
class AssignRolePanel extends AbstractPanel
{
    public $params;

    /**
     * @inheritDoc
     */
    public function getSendMessage()
    {
        $user = $this->params['user'];

        $m = parent::getSendMessage();
        $m->text = D::PANEL_CHANGE_ROLE . ' ' . $user['fullname'];
        $m->chat_id = $this->params['chatId'];

        return $m;
    }

    /**
     * @inheritDoc
     */
    public function create()
    {
        $callback['action'] = D::CALLBACK_ROLES_PANEL;
        $callback['userId'] = $this->params["userId"];
        $callback['roleId'] = D::ROLE_ADMIN;

        $this->addInlineButton(D::BTN_INLINE_ROLE_ADMIN, 1, $this->callbackPrepare($callback));

        $callback['roleId'] = D::ROLE_QV;
        $this->addInlineButton(D::BTN_INLINE_ROLE_SALE, 1, $this->callbackPrepare($callback));

        $callback['roleId'] = D::ROLE_NO_AUTH;
        $this->addInlineButton(D::BTN_INLINE_ROLE_GUEST, 1, $this->callbackPrepare($callback));
    }
}
