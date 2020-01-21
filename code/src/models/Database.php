<?php

namespace Fp\Telebot\models;

use Fp\Telebot\helpers\Env;
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
        if (self::$instance === null) {
            self::$instance = new self([
                'database_type' => 'pgsql',
                'database_name' => Env::postgresName(),
                'server' => Env::postgresHost(),
                'port' => Env::postgresPort(),
                'username' => Env::postgresUser(),
                'password' => Env::postgresPassword()
            ]);
        }

        return self::$instance;
    }

    public function addIfExist()
    {

    }
}
