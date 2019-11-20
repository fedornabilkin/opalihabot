<?php

namespace Fp\Telebot\handlers;

use DateTime;
use Fp\Telebot\models\GroupModel;
use Fp\Telebot\models\NotesModel;
use Fp\Telebot\models\NotifyModel;
use Fp\Telebot\models\UserModel;

/**
 * Class CronHandler
 * @package Fp\Telebot\handlers
 */
class CronHandler extends AbstractHandler
{
    public function sendFileFiled()
    {
        $text = 'Файл не обновился';
        $this->sendAdmin($text);
    }

    /**
     * @param int $data
     */
    public function sendAdmin($text)
    {
        $text = $text ?? 'Статус обновления файла ошибочный';

        $chatIds = (new UserModel())->getAdminsChatIds();

        $m = $this->setMethodMultipleChats($text, $chatIds);
        $this->pushMethod($m);
    }

    public function sendFileUpdate()
    {
        $text = 'Файл обновился';
        $this->sendAdmin($text);
    }

    public function sendMonitoring()
    {
        $text = "Файл не обновился, рассылка пользователям не произведена.\nЗапущен процесс мониторинга.";
        $this->sendAdmin($text);
    }

    public function sendGroup()
    {
        $chatIds = (new GroupModel())->getModeratorChatIds();

        $messages = [
            'Сообщение в группу',
        ];

        $this->setMultipleMessagesMultipleChats($messages, $chatIds);
    }

    public function sendUser()
    {
        $userModel = new UserModel();
        $chatIds = ($userModel)->getAdminsChatIds();

        // counters
        $users = $userModel->count();
        $notes = (new NotesModel())->count();

        $msg = "*Регулярное*\nUsers: " . $users . "\nNotes: " . $notes . "\n";

        $this->setMultipleMessagesMultipleChats([$msg], $chatIds);
    }

    public function sendIpu()
    {
        $users = (new UserModel())->getUsers();
        $chatIds = array_column($users, 'chatid');

        $text = "Показания ИПУ принимаются с 14 по 24 число каждого месяца";

        $m = $this->setMethodMultipleChats($text, $chatIds);
        $this->pushMethod($m);
    }

    public function sendNotifyAll()
    {
        $time = new DateTime();
        $m = [];

        $timeCode = $time->format('H') . $time->format('i');
        $dayCode = $time->format('w');

        $rows = (new NotifyModel())->getNotify($timeCode, $dayCode);

        foreach ($rows as $row) {
            $m[$row['id']] = $this->setMethodMessage($row['text'], $row['chatid']);
        }

        if ($m) {
            $this->pushMethod($m);
        }
    }
}
