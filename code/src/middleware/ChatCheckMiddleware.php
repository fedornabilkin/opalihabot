<?php


namespace Fp\Telebot\middleware;


class ChatCheckMiddleware extends AbstractMiddleware
{

    /**
     * @inheritDoc
     */
    public function check(): bool
    {
        $this->chatType();
        return parent::check();
    }

    protected function chatType()
    {
        $type = $this->getChatType();

        if ($type === self::$requestData::CHAT_PRIVATE) {
            $middleware = new UserExistMiddleware();
        } elseif ($type === self::$requestData::CHAT_GROUP) {
            $middleware = new GroupExistMiddleware();
        }

        if (isset($middleware)) {
            $this->insertNext($middleware);
        }

        $this->consoleLog('type: ' . $type);
    }
}
