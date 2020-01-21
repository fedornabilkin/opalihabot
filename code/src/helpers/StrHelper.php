<?php
/**
 * Created by PhpStorm.
 * User: fedornabilkin
 * Date: 21.01.2020
 * Time: 21:39
 */

namespace Fp\Telebot\helpers;

class StrHelper
{
    public static function camelCaseToUnderscore(string $str): string
    {
        $closure = function (array $param): string {
            return '_' . strtolower($param[1]);
        };

        return preg_replace_callback('/([A-Z])/', $closure, $str);
    }
}
