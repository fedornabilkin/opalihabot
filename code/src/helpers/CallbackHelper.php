<?php


namespace Fp\Telebot\helpers;

/**
 * Class CallbackHelper
 * @package Fp\Telebot\helpers
 */
class CallbackHelper
{
    /**
     * Преобразует массив $key => $value в строку запроса key=val&key1=val1
     *
     * @param array $data
     * @return string
     */
    public static function prepare(array $data)
    {
        $arr = [];
        foreach ($data as $key => $value){
            $arr[] = $key .'='. $value;
        }

        return \implode('&', $arr);
    }

    /**
     * Разбирает строку запроса в массив $key => $value
     *
     * @param $string
     * @return array
     */
    public static function parse($string)
    {
        $output = [];
        \parse_str($string, $output);
        return $output;
    }

    /**
     * @param $updateData
     * @return bool
     */
    public static function isCallbackQuery($updateData)
    {
        return \is_object($updateData)
            && isset($updateData->callback_query)
            && \is_object($updateData->callback_query);
    }
}
