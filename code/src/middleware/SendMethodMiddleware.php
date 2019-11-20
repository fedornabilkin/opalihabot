<?php

namespace Fp\Telebot\middleware;

use Fp\Telebot\Sender;

class SendMethodMiddleware extends AbstractMiddleware
{
    private $message;

    /**
     * @inheritDoc
     */
    public function check(): bool
    {
        $this->sendMethods();
        return parent::check();
    }

    /**
     * @return bool
     */
    private function sendMethods()
    {
        $this->message = $this->getData()->getMessage();

        $methods = $this->getData()->getMethods();

        if (!$methods || !is_array($methods)) {
            $this->consoleLog('Not found objects ' . __METHOD__);
            return false;
        }

        foreach ($methods as $method) {
            $this->send($method);
        }

        return true;
    }

    /**
     * @param $method
     */
    private function send($method)
    {
        if (!$method->chat_id) {
            $method->chat_id = $this->message->chat->id;
        }

        $this->consoleLog('send: ' . $method->chat_id);

        (new Sender($this->getData()->getTgLog(), $this->getData()->getLoop()))->send($method);
    }
}
