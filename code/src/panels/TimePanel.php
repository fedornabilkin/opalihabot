<?php
/**
 * Created by PhpStorm.
 * User: fedornabilkin
 * Date: 08.06.2019
 * Time: 23:25
 */

namespace Fp\Telebot\panels;

use Fp\Telebot\Dictionary as D;
use Fp\Telebot\helpers\CalendarHelper;

class TimePanel extends AbstractPanel
{
    public $params;

    /**
     * @inheritDoc
     */
    public function getSendMessage()
    {
        $m = parent::getSendMessage();
        $m->text = '*timePanel*';
        return $m;
    }

    public function create()
    {
        $callback[D::CALLBACK_PM_ACTION] = D::CALLBACK_NOTIFY_ADD_TIME;
        $callback['rowId'] = $this->params['rowId'];
        $callback['dayHook'] = $this->params['dayHook'];

        for ($h=0; $h<=24; $h++){
            $col = '';
            for($m=0; $m<4; $m++){
                if ($h > 0) {
                    $min = $m===0 ? '00' : $m*15;
                    $hour = $h<10 ? "0$h" : $h;

                    $timeText = $hour .':'. $min;
                    $callback['timeHook'] = CalendarHelper::timeHookEncode($hour, $min);
                    $this->addInlineButton($timeText, $hour, $this->callbackPrepare($callback));
                    $col .= $timeText . '|';
                }
            }
        }

    }
}