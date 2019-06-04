<?php

namespace Fp\Telebot;

use Clue\React\Socks\Client;
use Fp\Telebot\helpers\ConsoleHelper;
use Psr\Http\Message\ServerRequestInterface;
use React\EventLoop\Factory;
use React\Http\Response;
use React\Http\Server;
use React\Socket\Connector;
use unreal4u\TelegramAPI\HttpClientRequestHandler;
use unreal4u\TelegramAPI\Telegram\Methods\GetUpdates;
use unreal4u\TelegramAPI\TgLog;

/**
 * Class Main
 * @package Fp\Telebot
 */
class Main
{

    private $httpHandler;
    private $loop;
    private $connector;
    private $tgLog;
    private $lastId;
    private $maxIter;

    public function __construct($loop = null, $connector = null)
    {
        $this->loop = $loop;
        if ($this->loop === null) {
            $this->loop = Factory::create();
        }

        $params = [];
        if ($this->useProxy()) {
            $params['tcp'] = $this->getProxyClient();
        }

        $this->httpHandler = new HttpClientRequestHandler($this->loop, $params);

        $this->tgLog = new TgLog(BOT_TOKEN, $this->httpHandler);

        $this->connector = $connector;
        $this->lastId = 352050076;
        $this->maxIter = 2;
    }

    public function setLastId($lastId)
    {
        $this->lastId = $lastId;
    }

    public function getLastId()
    {
        return $this->lastId;
    }

    public function initMainLoop()
    {
        $this->initUpdateLoop();
        $this->initListenLoop();
        $this->loop->run();
    }

    private function initUpdateLoop()
    {
        ConsoleHelper::consoleLog('Start init', 'd.m.y H:i:s');

        $getUpdates = new GetUpdates();
        $getUpdates->offset = $this->getLastId();
        $getUpdates->timeout = 45;

        $updatePromise = $this->tgLog->performApiRequest($getUpdates);

        $updatePromise->then(function ($updatesArray) {
            foreach ($updatesArray as $update) {
                $updateHandler = new UpdateHandler($this->tgLog, $this->loop, $update);

                $updateHandler->handle();

                $updateId = $updateHandler->getUpdateId() + 1;

                if ($updateId) {
                    $this->setLastId($updateId);
                }
            }

            $this->initUpdateLoop();
        });
    }

    public function initListenLoop()
    {

        $server = new Server(function (ServerRequestInterface $request) {
            $path = $request->getUri()->getPath();

            $args = explode("/", $path);

            if (isset($args[1]) && $args[1] == 'action' && isset($args[2])) {
                $updateHandler = new UpdateHandler($this->tgLog, $this->loop);
                $updateHandler->setArguments($args);
                $updateHandler->handle();
            }

            return new Response(200, array('Content-Type' => 'text/plain'), "{error:false}\n");
        });

        $socket = new \React\Socket\Server('0.0.0.0:8082', $this->loop);

        $server->listen($socket);

        ConsoleHelper::consoleLog('Listening on ' . str_replace('tcp:', 'http:', $socket->getAddress()));
    }

    /**
     * @return bool
     */
    protected function useProxy()
    {
        return defined('PROXY_USE') && PROXY_USE;
    }

    /**
     * @return Client
     */
    protected function getProxyClient()
    {
        return new Client('socks5://'
            . PROXY_USER . ':' . PROXY_PASS
            . '@' . PROXY_ADDRESS . ':' . PROXY_PORT, new Connector($this->loop));
    }
}
