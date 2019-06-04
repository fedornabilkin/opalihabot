<?php

define('ENV', 'PROD'); // DEV, TEST, PROD
define('BOT_TOKEN', '');
define('HOST_IP', '10.0.2.15');

define('PROXY_USE', false);

define('DB_CONNECT_DATA', [
    'database_type' => 'pgsql',
    'database_name' => 'telebot_opaliha',
    'server' => HOST_IP,
    'port' => '5442',
    'username' => 'root',
    'password' => '252525'
]);

define('USER_CHAT_IDS', []);
