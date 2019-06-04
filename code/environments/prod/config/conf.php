<?php

$localConfig = __DIR__ . '/conf-local.php';
if (file_exists($localConfig)) {
    require_once $localConfig;
}

define('A_USER_CHAT_ID', 'XXXXXXXXX');
define('A_GROUP_CHAT_ID', 'XXXXXXXXX');

define('A_FILE_ID', 'XXXXXXXXXXXXXXXXXXXXXXXX');
define('A_USER_ID', 'XXXXXXXX');
define('PAYMENT_TOKEN', '123412341234:TEST:XXXXXXXXXXX');

define('WKHTML_URL', 'http://' . HOST_IP . ':8089');

define('PAST_FACT_FILE_PATH', '/update/rev_today.html');
define('PAST_FACT_FILE_PATH_RB', '/update/rev_today_rb.html');
define('PAST_FACT_FILE_PATH_RB_PFM', '/update/rev_today_rb_pfm.html');
define('PAST_FACT_FILE_PATH_LV', '/update/rev_today_lv.html');
