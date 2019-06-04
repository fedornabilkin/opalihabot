<?php


include __DIR__ . '/vendor/autoload.php';

use Fp\Filechecker\Main;

if (isset($argv[1])) {

    $main = new Main();

//    if ($argv[1] == "admin") {
//        $main->adminCheck();
//    } elseif ($argv[1] == "user") {
//        $main->userCheck();
//    } elseif ($argv[1] == 'detailed') {
//        $main->detailedCheck();
//    }
}
