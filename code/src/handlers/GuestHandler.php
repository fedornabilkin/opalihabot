<?php


namespace Fp\Telebot\handlers;

use Fp\Telebot\buttons\GuestButtons;
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

    public function __construct()
    {
        $this->consoleLog(self::class);
        $this->setInstanceButtons(new GuestButtons());

        parent::__construct();
    }

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
        } else {
            $text = 'Необходимо указать текст записи';
        }

        $m[] = $this->setMethodMessage($text, $chatId);
        $this->pushMethod($m);
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

        $model->update(['status' => (int) $status], $row['id']);
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
     * Отображает запись с кнопками выбора дней оповещения
     */
    public function initNotifyDayPanel()
    {
//        $row = (new NotesModel())->getRow($this->callbackQueryData['rowId']);

//        $this->callbackQueryData["chatId"] = $this->message->chat->id;
//        $this->callbackQueryData['row'] = $row;

        $panel = new NotifyDayPanel();
        $panel->params = $this->callbackQueryData;

        $this->pushMethod($panel->getSendMessage());
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

        if($dayHook === 'all'){
            $days = array_keys($this->calendar::getDayMap());
        }elseif ($dayHook === 'one'){
            $days = array_keys($this->calendar::getWorkDays());
        }elseif ($dayHook === 'two'){
            $days = array_keys($this->calendar::getWeekendDays());
        }

        foreach ($days as $day) {
            $data = [
                'notesid' => $this->callbackQueryData['rowId'],
                'timecode' => (int) $this->callbackQueryData['timeHook'],
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
        **Управляющая компания**
        Понедельник-пятница: __08:00-17:00__
        Перерыв: __13:00-14:00__
        
        **Бухгалтерия**
        Понедельник-пятница: 09:00-18:00
        Суббота: 09:00-16:00
        
        **Паспортный стол**
        Вторник-пятница: 08:00-17:00
        Среда  –  выездной день в ФМС
        Суббота: 09:00-13:00 прием документов
        13:00-16:00 обработка документов
        Понедельник/воскресенье - выходной
        ";

        $m[] = $this->setMethodMessage($text, $this->message->chat->id);
        $this->pushMethod($m);
    }

    public function infoTaxi()
    {
        $text = "
        **Taxi**
        Опалиха:\n __8 495 509 14 44__
        Ямщикъ:\n __8 495 255 05 05__
        Luxe:\n __8 495 212 12 20__\n __8 499 281 82 81__
        ";

        $m[] = $this->setMethodMessage($text, $this->message->chat->id);
        $this->pushMethod($m);
    }

    public function infoApteka()
    {
        $text = "
        **Круглосуточные аптеки**
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
