<?php

namespace Fp\Telebot\models;

use Medoo\Medoo;

/**
 * Class Database
 * @package Fp\Telebot\models
 */
class Database extends Medoo
{
    /** @var Medoo */
    static private $instance;

    public function __construct($options)
    {
        parent::__construct($options);
    }

    /** @return Medoo */
    public static function getInstance()
    {
        if (self::$instance == null) {
            self::$instance = new self([
                'database_type' => DB_CONNECT_DATA['database_type'],
                'database_name' => DB_CONNECT_DATA['database_name'],
                'server' => DB_CONNECT_DATA['server'],
                'port' => DB_CONNECT_DATA['port'],
                'username' => DB_CONNECT_DATA['username'],
                'password' => DB_CONNECT_DATA['password']
            ]);
        }

        return self::$instance;
    }

    public function addIfExist()
    {

    }
}
