<?php

namespace Fp\Telebot\handlers;

use Fp\Telebot\Dictionary as D;
use Fp\Telebot\models\RoleModel;
use Fp\Telebot\models\RoleUserModel;
use Fp\Telebot\models\UserModel;
use Fp\Telebot\models\UserStoryModel;
use Fp\Telebot\panels\AssignRolePanel;
use Fp\Telebot\panels\TimePanel;

/**
 * Class AdminHandler
 * @package Fp\Telebot\handlers
 */
class AdminHandler extends ModeratorHandler
{
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

    public function lastCmdList()
    {
        $model = new UserStoryModel();
        $list = $model->lastCommand();
        $text = '';

        foreach ($list as $cmd){
            $dt = date('d.m.y H:i:s', strtotime($cmd['datetime']));
            $text .= "_{$dt}_ - {$cmd['text']} \n";
        }

        $m[] = $this->setMethodMessage($text, $this->message->chat->id);
        $this->pushMethod($m);
    }

    public function test()
    {

        $msg[] = $this->setMethodMessage('pre text', $this->message->chat->id);
        $this->pushMethod($msg);

        $panel = new TimePanel();

        $this->pushMethod($panel->getSendMessage());

//        $rows = '';
//        for ($h=0; $h<=24; $h++){
//            $col = '';
//            for($m=1; $m<=6; $m++){
//                if ($h===0) {
//                    $col .= "$m|";
//                }else{
//                    $col .= "$h$m|";
//                }
//            }
//            $rows .= $h .'| '. $col . "\n";
//        }
//
//        $msg[] = $this->setMethodMessage($rows, $this->message->chat->id);
//        $this->pushMethod($msg);
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
