<?php


include __DIR__ . '/vendor/autoload.php';

use Fp\Filechecker\Main;

if (isset($argv[1])) {

    (new Main())->action($argv[1]);

}
