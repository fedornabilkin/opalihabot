<?php

include __DIR__ . '/config/basics.php';

use Fp\Telebot\Main;

echo 'run' . PHP_EOL;

$main = new Main();

$main->initMainLoop();
