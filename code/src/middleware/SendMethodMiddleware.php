<?php


namespace Fp\Telebot\middleware;


use Fp\Telebot\Sender;

class SendMethodMiddleware extends AbstractMiddleware
{
    private $tgLog;
    private $loop;
    private $message;

    /**
     * @inheritDoc
     */
    public function check(): bool
    {
        $this->consoleLog(self::class);
        $this->sendMethods();
        return parent::check();
    }

    /**
     * @return bool
     */
    private function sendMethods()
    {
        $data = self::$requestData;
        $this->tgLog = $data->getTgLog();
        $this->loop = $data->getLoop();
        $this->message = $data->getMessage();

        $methods = $data->getMethods();

        if(!$methods || !is_array($methods)){
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
     * @param bool $chatId
     */
    private function send($method, $chatId = false)
    {
        if ($chatId) {
            $method->chat_id = $chatId;
        } elseif (!$method->chat_id) {
            $method->chat_id = $this->message->chat->id;
        }

        $this->consoleLog('send: ' . $method->chat_id);

        (new Sender($this->tgLog, $this->loop))->send($method);
    }
}
