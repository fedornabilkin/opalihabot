<?php


namespace Fp\Telebot\middleware;


use Fp\Telebot\helpers\CallbackHelper;
use function substr;

/**
 * Class RequestCheckMiddleware
 * @package Fp\Telebot\middleware
 */
class RequestCheckMiddleware extends AbstractMiddleware
{
    private $updateData;

    /**
     * @inheritDoc
     */
    public function check(): bool
    {
        $this->updateData = self::$requestData->getUpdateData();

        $this->checkRequest();
        $this->insertNext(new UpdateDataMiddleware());

        return parent::check();
    }

    protected function checkRequest()
    {
        self::$requestData->setIsCron($this->isCron());
        self::$requestData->setIsCallback($this->isCallback());
        self::$requestData->setIsCommand($this->isCommand());
    }

    /**
     * @return bool
     */
    protected function isCron()
    {
        return !$this->updateData;
    }

    /**
     * @return bool
     */
    protected function isCallback()
    {
        return CallbackHelper::isCallbackQuery($this->updateData);
    }

    /**
     * @return bool
     */
    protected function isCommand()
    {
        if (isset($this->updateData->message->text)) {

            if ('/' === substr($this->updateData->message->text, 0, 1)) {
                return true;
            }
        }

        return false;
    }
}
