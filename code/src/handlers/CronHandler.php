<?php


namespace Fp\Telebot\handlers;


use DateTime;
use Fp\Telebot\Dictionary as D;
use Fp\Telebot\models\GroupModel;
use Fp\Telebot\models\NotifyModel;
use Fp\Telebot\models\UserModel;
use function array_merge;

/**
 * Class CronHandler
 * @package Fp\Telebot\handlers
 */
class CronHandler extends AbstractHandler
{

    public function __construct()
    {
        $this->consoleLog(self::class);
        parent::__construct();
    }

    public function sendFileFiled()
    {
        $text = 'Файл не обновился';
        $this->sendAdmin($text);
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
        $chatIds = (new UserModel())->getAdminsChatIds();

        $messages = [
            'Сообщение пользователям: ' . date('H:i:s'),
        ];

        $this->setMultipleMessagesMultipleChats($messages, $chatIds);
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

        foreach ($rows as $row){
            $m[$row['id']] = $this->setMethodMessage($row['text'], $row['chatid']);
        }

        if ($m) {
            $this->pushMethod($m);
        }
    }
}
