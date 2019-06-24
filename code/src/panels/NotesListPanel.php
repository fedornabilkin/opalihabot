<?php
/**
 * Created by PhpStorm.
 * User: fedornabilkin
 * Date: 09.06.2019
 * Time: 13:16
 */

namespace Fp\Telebot\panels;

use Fp\Telebot\Dictionary as D;

class NotesListPanel extends AbstractPanel
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
        $m->text = D::PANEL_NOTES_LIST;
        return $m;
    }

    public function create()
    {
        $callback[D::CALLBACK_PM_ACTION] = D::CALLBACK_NOTES_PANEL;
        foreach ($this->rows as $key => $row) {

            $text = $row['text'];

            $callback['rowId'] = $row["id"];

            $this->addInlineButton($text, $key, $this->callbackPrepare($callback));
        }
    }
}