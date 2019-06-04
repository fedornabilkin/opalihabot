<?php

use Fp\Tests\Telebot\TelebotTest;
use React\EventLoop\Factory;
use unreal4u\TelegramAPI\HttpClientRequestHandler;
use unreal4u\TelegramAPI\Telegram\Methods\SendMessage;
use unreal4u\TelegramAPI\TgLog;

include __DIR__ . '/../examples/basics.php';

$telebotTest = new TelebotTest;

try {
    $telebotTest->testOnlineSales();
} catch (Exception $e) {
    sendErrorReport($e->getMessage());
}

try {
    $telebotTest->testPastFact();
} catch (Exception $e) {
    sendErrorReport($e->getMessage());
}


/**
 * Отправка ботом сообщения об ошибке в телеграм
 * @param string $message
 */
function sendErrorReport($message)
{
    $loop = Factory::create();
    $tgLog = new TgLog(BOT_TOKEN, new HttpClientRequestHandler($loop));

    $sendMessage = new SendMessage();
    $sendMessage->chat_id = A_USER_CHAT_ID;
    $sendMessage->parse_mode = 'html';
    $sendMessage->text = '<b>' . $message . '</b>';
    $tgLog->performApiRequest($sendMessage);

    $loop->run();
}
