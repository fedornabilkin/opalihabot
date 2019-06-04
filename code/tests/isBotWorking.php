<?php

include __DIR__ . '/../examples/basics.php';

$ch = curl_init('https://api.telegram.org/bot' . BOT_TOKEN . '/getMe');
curl_setopt($ch, CURLOPT_HEADER, false);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
$result = curl_exec($ch);
curl_close($ch);

echo($result && strpos($result, '"ok":true') ? 'ok' : '');
