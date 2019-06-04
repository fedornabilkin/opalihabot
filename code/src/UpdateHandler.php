<?php

namespace Fp\Telebot;

use Fp\Telebot\helpers\ConsoleHelper;
use Fp\Telebot\middleware\ChatCheckMiddleware;
use Fp\Telebot\middleware\CommandsCheckMiddleware;
use Fp\Telebot\middleware\HandlerExecMiddleware;
use Fp\Telebot\middleware\RequestCheckMiddleware;
use Fp\Telebot\middleware\RoleCheckMiddleware;
use Fp\Telebot\middleware\SendMethodMiddleware;
use Fp\Telebot\middleware\UserStoryMiddleware;
use React\EventLoop\StreamSelectLoop;
use unreal4u\TelegramAPI\Telegram\Types\Update;
use unreal4u\TelegramAPI\TgLog;

/**
 * Class UpdateHandler
 * @package Fp\Telebot
 */
class UpdateHandler
{

    /** @var Update */
    private $updateData;

    /** @var int */
    private $updateId;

    /** @var TgLog */
    private $tgLog;

    /** @var StreamSelectLoop */
    private $loop;

    /** @var array */
    private $arguments;

    public function __construct($tgLog, $loop, $updateData = null)
    {
        $this->tgLog = $tgLog;
        $this->loop = $loop;

        if ($updateData) {
            $this->updateData = $updateData;

            $this->updateId = $this->updateData->update_id;
        }
    }

    /**
     * @param array $arguments
     */
    public function setArguments($arguments): void
    {
        $this->arguments = $arguments;
    }

    public function handle()
    {
        $data = new RequestData();
        $data->setTgLog($this->tgLog);
        $data->setLoop($this->loop);
        $data->setUpdateData($this->updateData);
        $data->setArguments($this->arguments);

        $middleware = new RequestCheckMiddleware();
        $middleware->setData($data);


        $middleware
            ->linkWith(new ChatCheckMiddleware())
            ->linkWith(new RoleCheckMiddleware())
            ->linkWith(new UserStoryMiddleware())
            ->linkWith(new CommandsCheckMiddleware())
            ->linkWith(new HandlerExecMiddleware())
            ->linkWith(new SendMethodMiddleware());

        $middleware->check();
    }

    public function getUpdateId()
    {
        return $this->updateId;
    }

    protected function consoleLog($text)
    {
        ConsoleHelper::consoleLog($text);
    }
}
