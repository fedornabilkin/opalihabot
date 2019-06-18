<?php
/**
 * Created by PhpStorm.
 * User: fedornabilkin
 * Date: 12.06.2019
 * Time: 11:32
 */

namespace Fp\Telebot\panels;

use Fp\Telebot\Dictionary as D;
use Fp\Telebot\helpers\CalendarHelper;
use Fp\Telebot\models\NotesModel;
use Fp\Telebot\models\NotifyModel;

class NotifyDayPanel extends AbstractPanel
{
    public $params;
    protected $notesText;
    /** @var CalendarHelper */
    private $calendar;

    /**
     * @inheritDoc
     */
    public function getSendMessage()
    {
        $this->calendar = $this->getCalendar();

        $m = parent::getSendMessage();
        $m->text = "*Управление записью*\n" . $this->notesText . "\n" . $this->getTimeText();
        return $m;
    }

    public function create()
    {
        $callback['rowId'] = $this->params['row']['id'];

        $model = new NotesModel();
        $row = $model->getRow($callback['rowId']);
        $this->notesText = $row['text'];

        $callback[D::CALLBACK_PM_ACTION] = D::CALLBACK_TIME_PANEL;
        $callback['dayHook'] = 'all';
        $this->addInlineButton('Каждый день', 1, $this->callbackPrepare($callback));

        $callback[D::CALLBACK_PM_ACTION] = D::CALLBACK_NOTES_TOGGLE;
        $this->addInlineButton($row['status'] ? 'Выкл' : 'Вкл', 1, $this->callbackPrepare($callback));

        $callback[D::CALLBACK_PM_ACTION] = D::CALLBACK_NOTES_REMOVE;
        $this->addInlineButton('Удалить', 1, $this->callbackPrepare($callback));

        $days = $this->calendar::getDayMap();
        $callback[D::CALLBACK_PM_ACTION] = D::CALLBACK_TIME_PANEL;

        foreach ($days as $key => $day) {
            $callback['dayHook'] = $key;
            $this->addInlineButton($day, 2, $this->callbackPrepare($callback));
        }
    }

    public function getTimeText()
    {
        $id = $this->params['row']['id'];
        $rows = (new NotifyModel())->getNotifyByNotesId($id);
        $txt = $rows ? "_Время уведомления_\n" : '_Время уведомления не указано_';
        $days = [];

        foreach ($rows as $row){
            $days[$row['daycode']][] = $this->calendar::getTimeFromHook($row['timecode']);
        }

        if ($days) {
            $daysMap = $this->calendar::getDayMap();
            foreach ($daysMap as $key => $day) {
                $time = $days[$key] ?? [];
                $txt .= $daysMap[$key] . ': ' . implode(', ', $time) . "\n";
            }
        }

        return $txt;
    }

    protected function getCalendar()
    {
        return new CalendarHelper();
    }
}