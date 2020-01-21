<?php
/**
 * Created by PhpStorm.
 * User: fedornabilkin
 * Date: 21.01.2020
 * Time: 21:37
 */

namespace Fp\Telebot\helpers;

/**
 * @method static string botToken()
 * @method static string environment()
 *
 * @method static string hostIp()
 * @method static string wkhtmlPort()
 * @method static string appPort()
 * @method static string webPort()
 *
 * @method static string postgresHost()
 * @method static string postgresPort()
 * @method static string postgresName()
 * @method static string postgresUser()
 * @method static string postgresPassword()
 *
 * @method static string proxyUse()
 * @method static string proxyAddress()
 * @method static string proxyPort()
 * @method static string proxyUser()
 * @method static string proxyPassword()
 *
 * Class Env
 * @package Fp\Telebot\helpers
 */
class Env
{
    public static function __callStatic($name, $arguments)
    {
        return getenv('B_' . strtoupper(self::underscore($name)));
    }

    public static function underscore(string $name): string
    {
        return StrHelper::camelCaseToUnderscore($name);
    }
}
