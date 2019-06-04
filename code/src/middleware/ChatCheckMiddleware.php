<?php


namespace Fp\Telebot\middleware;


class ChatCheckMiddleware extends AbstractMiddleware
{

    /**
     * @inheritDoc
     */
    public function check(): bool
    {
        $this->consoleLog(self::class);
        $this->chatType();
        return parent::check();
    }

    protected function chatType()
    {
        $type = $this->getChatType();

        if ($type === 'private') {
            $this->insertNext(new UserExistMiddleware());
        } elseif ($type === 'group') {
            $this->insertNext(new GroupExistMiddleware());
        }

        $this->consoleLog('type: ' . $type);
    }

    /**
     * @return bool|string
     */
    protected function getChatType()
    {
        if (!isset(self::$requestData->getMessage()->chat)) {
            return false;
        }
        return self::$requestData->getMessage()->chat->type;
    }
}
