<?php

namespace Fp\Telebot\helpers;

class ConsoleHelper
{
    /**
     * @param $value
     * @param string $dateTimeFormat
     */
    public static function consoleLog($value, $dateTimeFormat = '')
    {
        if (Env::environment() !== 'DEV') {
            return;
        }

        echo (!$dateTimeFormat) ? '' : date($dateTimeFormat) . ' ';

        if (is_array($value)) {
            print_r($value);
        }
        if (is_object($value)) {
            var_dump($value);
        }

        if (is_string($value) || is_int($value)) {
            echo $value;
        }

        echo PHP_EOL;
    }
}
