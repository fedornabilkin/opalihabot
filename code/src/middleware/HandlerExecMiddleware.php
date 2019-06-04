<?php


namespace Fp\Telebot\middleware;


use Fp\Telebot\Dictionary as D;
use function call_user_func;

/**
 * Class HandlerExecMiddleware
 * @package Fp\Telebot\middleware
 */
class HandlerExecMiddleware extends AbstractMiddleware
{
    /**
     * @inheritDoc
     */
    public function check(): bool
    {
        $this->consoleLog(self::class);
        $this->execHandle();
        return parent::check();
    }

    protected function execHandle()
    {
        $data = self::$requestData;
        $commands = $data->getCommands();

        $handlerFunc = $commands->getHandlerFunc($data->getCommandType(), $data->getCommandValue());

        if ($handlerFunc) {
            call_user_func($handlerFunc);
            $data->setMethods($commands->getHandler()->getMethods());
        } else {
            $this->consoleLog(D::MSG_ERROR . ' call_user_func ' . __METHOD__);
            $this->stopProcessing();
        }
    }
}
