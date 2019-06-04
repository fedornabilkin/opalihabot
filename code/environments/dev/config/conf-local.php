<?php

define('ENV', 'DEV'); // DEV, TEST, PROD
define('BOT_TOKEN', '');
define('HOST_IP', '10.0.2.15');

// proxy settings
define('PROXY_USE', false);
define('PROXY_ADDRESS', '');
define('PROXY_PORT', '');
define('PROXY_USER', '');
define('PROXY_PASS', '');

define('DB_CONNECT_DATA', [
    'database_type' => 'pgsql',
    'database_name' => 'telebot_opaliha',
    'server' => HOST_IP,
    'port' => '5442',
    'username' => 'root',
    'password' => '252525'
]);

define('USER_CHAT_IDS', []);
