<?php

namespace Fp\Telebot\handlers;

use Fp\Telebot\Dictionary;
use Fp\Telebot\models\NotesModel;
use Fp\Telebot\models\NotifyModel;
use Fp\Telebot\models\UserModel;
use Fp\Telebot\panels\NotesListPanel;
use Fp\Telebot\panels\NotifyDayPanel;
use Fp\Telebot\panels\TimePanel;

/**
 * Class GuestHandler
 * @package Fp\Telebot\handlers
 */
class GuestHandler extends AbstractHandler
{
    /**
     * Добавляет запись
     */
    public function addNotes()
    {
        $chatId = $this->message->chat->id;
        $text = $this->message->text;
        $text = trim(str_replace(Dictionary::CMD_ADD, '', $text));

        if ($text) {
            $userId = (new UserModel())->getUserIdByChatId($chatId);
            $notesId = (new NotesModel())->insert(['text' => $text, 'userid' => $userId]);

            $text = "*Запись добавлена*\n" . $text;
            $this->callbackQueryData['rowId'] = $notesId;

            $this->initNotifyDayPanel();
        } else {
            $text = 'Необходимо указать текст записи';
        }

        $m[] = $this->setMethodMessage($text, $chatId);
        $this->pushMethod($m);
    }

    /**
     * Отображает запись с кнопками выбора дней оповещения
     */
    public function initNotifyDayPanel()
    {
        $panel = new NotifyDayPanel();
        $panel->params = $this->callbackQueryData;

        $this->pushMethod($panel->getSendMessage());
    }

    /**
     * Список записей в виде кнопок
     */
    public function notesList()
    {
        $chatId = $this->message->chat->id;
        $userId = (new UserModel())->getUserIdByChatId($chatId);

        $model = new NotesModel();
        $notes = $model->getNotesByUserId($userId);

        $panel = new NotesListPanel();
        $panel->setRows($notes);
        $this->pushMethod($panel->getSendMessage());

    }

    /**
     * Переключает статус записи
     */
    public function toggleNote()
    {
        $model = new NotesModel();
        $row = $model->getRow($this->callbackQueryData['rowId']);
        $status = !$row['status'];

        $model->update(['status' => (int)$status], $row['id']);
        $text = !$status ? 'выключена' : 'включена';

        $m[] = $this->setMethodMessage($text, $this->message->chat->id);
        $this->pushMethod($m);
    }

    /**
     * Удаляет запись
     */
    public function removeNote()
    {
        $model = new NotesModel();
        $model->delete($this->callbackQueryData['rowId']);

        $m[] = $this->setMethodMessage('Запись удалена', $this->message->chat->id);
        $this->pushMethod($m);
    }

    /**
     * Удаляет все настройки уведомлений
     */
    public function notifyClear()
    {
        $model = new NotifyModel();
        $model->delete(['notesid' => $this->callbackQueryData['rowId']]);

        $m[] = $this->setMethodMessage('Настройки уведомлений удалены', $this->message->chat->id);
        $this->pushMethod($m);
    }

    /**
     * Отображает кнопки выбора времени в зависимости от того, из какой записи была вызвана панель
     */
    public function initNotifyTimePanel()
    {
        $panel = new TimePanel();
        $panel->params = $this->callbackQueryData;

        $this->pushMethod($panel->getSendMessage());
    }

    /**
     * Добавляет день оповещения
     */
    public function addDayNotify()
    {
        $model = new NotifyModel();

        $data = [
            'notesid' => $this->callbackQueryData['rowId'],
            'daycode' => $this->callbackQueryData['dayHook'],
        ];

        $model->insert($data);
        $m[] = $this->setMethodMessage('День указан', $this->message->chat->id);
        $this->pushMethod($m);
    }

    /**
     * Добавляет время оповещения для указанного дня или всех дней
     */
    public function addTimeNotify()
    {
        $model = new NotifyModel();
        $days = [$this->callbackQueryData['dayHook']];
        $dayHook = $this->callbackQueryData['dayHook'];

        if ($dayHook === 'all') {
            $days = array_keys($this->calendar::getDayMap());
        } elseif ($dayHook === 'one') {
            $days = array_keys($this->calendar::getWorkDays());
        } elseif ($dayHook === 'two') {
            $days = array_keys($this->calendar::getWeekendDays());
        }

        foreach ($days as $day) {
            $data = [
                'notesid' => $this->callbackQueryData['rowId'],
                'timecode' => (int)$this->callbackQueryData['timeHook'],
                'daycode' => $day,
            ];
            $model->addNotify($data);
        }

        $m[] = $this->setMethodMessage('Время установлено', $this->message->chat->id);
        $this->pushMethod($m);
    }

    public function infoUk()
    {
        $text = "
        *Управляющая компания*
        Понедельник-пятница: _08:00-17:00_
        Перерыв: _13:00-14:00_
        
        *Бухгалтерия*
        Понедельник-пятница: 09:00-18:00
        Суббота: 09:00-16:00
        
        *Паспортный стол*
        Вторник-пятница: 08:00-17:00
        Среда – выездной день в ФМС
        Суббота: 09:00-13:00 - прием документов
        13:00-16:00 - обработка документов
        Понедельник/воскресенье - выходной
        
        *Контактные телефоны*
        _8-498-726-57-70_
        
        *Диспетчерская круглосуточная служба:*
        _8-499-426-64-29_
        _8-929-630-65-26_
        
        *Показания по ИПУ снимаются и подаются в управляющую компанию:*
        • ukopaliha.ru
        логин - _номер лицевого счета_
        пароль на первый вход - _123456_
        • Показания принимаются с 14 по 24 число каждого месяца
        ";

        $m[] = $this->setMethodMessage($text, $this->message->chat->id);
        $this->pushMethod($m);
    }

    public function infoTaxi()
    {
        $text = "
        *Taxi*
        Опалиха:\n _8 495 509 14 44_
        Ямщикъ:\n _8 495 255 05 05_
        Luxe:\n _8 495 212 12 20_\n _8 499 281 82 81_
        ";

        $m[] = $this->setMethodMessage($text, $this->message->chat->id);
        $this->pushMethod($m);
    }

    public function infoApteka()
    {
        $text = "
        *Круглосуточные аптеки*
        • Планета здоровья
        ул. Геологов, 17, 
        мкр. Опалиха
        8 (800) 755-05-00
        
        • Планета здоровья
        бул. Космонавтов, 4,
        Красногорск
        8 (800) 755-05-00
        
        • Первый мед
        ул. Ленина, 38Б
        Красногорск
        +7 (495) 565-18-58
        
        • Профессионал
        ул. Ленина, 30А
        Красногорск
        +7 (495) 564-66-13
        
        • Аптека 36,6
        ул. Ленина, 21
        Красногорск
        8 (800) 200-63-03
        ";

        $m[] = $this->setMethodMessage($text, $this->message->chat->id);
        $this->pushMethod($m);
    }
}
