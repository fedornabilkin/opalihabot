<?php

namespace Fp\Telebot\middleware;

use Fp\Telebot\Dictionary as D;
use Fp\Telebot\helpers\CallbackHelper;

/**
 * Class UpdateDataMiddleware
 * @package Fp\Telebot\middleware
 */
class UpdateDataMiddleware extends AbstractMiddleware
{
    private $data;

    /**
     * @inheritDoc
     */
    public function check(): bool
    {
        $this->data = self::$requestData->getUpdateData();

        $this->update();
        return parent::check();
    }

    protected function update()
    {
        $text = $userId = $message = null;

        // for cron and default
        $commandType = D::REQ_TYPE_TEXT;
        $commandValue = self::$requestData->getArguments()[2];

        if (self::$requestData->getIsCallback()) {
            $text = $this->data->callback_query->data;
            $userId = $this->data->callback_query->from->id;
            $message = $this->data->callback_query->message;
            $commandType = D::REQ_TYPE_CALLBACK;
            $commandValue = CallbackHelper::parse($text)[D::CALLBACK_PM_ACTION];
            self::$requestData->setUser($this->data->callback_query->from);
        } elseif (isset($this->data->message->text)) {
            $text = $this->data->message->text;
            $userId = $this->data->message->from->id;
            $message = $this->data->message;
            $commandValue = $text;
            self::$requestData->setUser($message->from);

            if (self::$requestData->getIsCommand()) {
                $commandType = D::REQ_TYPE_COMMAND;
                $arr = explode(' ', $text);
                if (isset($arr[0])) {
                    $commandValue = $arr[0];
                }
            }
        }

        self::$requestData->setText($text);
        self::$requestData->setUserId($userId);
        self::$requestData->setMessage($message);
        self::$requestData->setCommandType($commandType);
        self::$requestData->setCommandValue($commandValue);

        if (isset($message->chat)) {
            self::$requestData->setGroup($message->chat);
            self::$requestData->setGroupId($message->chat->id);
        }
    }
}
