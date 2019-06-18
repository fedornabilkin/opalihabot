<?php
/**
 * Created by PhpStorm.
 * User: fedornabilkin
 * Date: 12.06.2019
 * Time: 18:05
 */

namespace Fp\Telebot\helpers;


class CalendarHelper
{
    public static function getDayMap()
    {
        return [
            1 => 'Пн',
            2 => 'Вт',
            3 => 'Ср',
            4 => 'Чт',
            5 => 'Пт',
            6 => 'Сб',
            7 => 'Вс',
        ];
    }

    public static function timeHookEncode($h, $m)
    {
        return $h . $m;
    }

    public static function getTimeFromHook($hook)
    {
        $arr = self::timeHookDecode($hook);
        return $arr['hour'] . ':' . $arr['min'];
    }

    public static function timeHookDecode($hook)
    {
        return [
            'hour' => substr($hook, 0, -2),
            'min' => substr($hook,-2),
        ];
    }

    public static function getDayFromHook($hook)
    {

    }
}