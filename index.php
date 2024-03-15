<?php

use App\AlarmAPIs\AlertsInUA;
use App\AlarmHandler;
use App\Handlers\TelegramHandler;

ini_set('error_reporting', E_ALL);
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);

require "vendor/autoload.php";

var_dump(1);

$alarmHandler = new AlarmHandler();
$alarmHandler->setAlarmAPI(new AlertsInUA());
$alarmHandler->setHandler(new TelegramHandler());
$alarmHandler->work();

?>