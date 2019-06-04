<?php


namespace Fp\Wkhtml;

use Knp\Snappy\Image;
use Psr\Http\Message\ServerRequestInterface;
use React\EventLoop\Factory;
use React\Http\Response;
use React\Http\Server;

/**
 * Class Main
 * @package Fp\Wkhtml
 */
class Main
{

    public function initMainLoop()
    {
        $loop = Factory::create();

        $server = new Server(function (ServerRequestInterface $request) {

            $snappy = new Image('/usr/bin/wkhtmltoimage');
            try {
                $snappy->setOption("javascript-delay", "2000");
                $img = $snappy->getOutput("http://ablaki.ru/statistic");
            } catch (\Exception $e) {
                var_dump($e);
            }

            return new Response(
                200, array('Content-Type' => 'image/jpeg'), $img
            );
        });

        $socket = new \React\Socket\Server('0.0.0.0:8081', $loop);

        $server->listen($socket);

        echo 'Listening on ' . str_replace('tcp:', 'http:', $socket->getAddress()) . PHP_EOL;

        $loop->run();
    }
}