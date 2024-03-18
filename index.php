<?php

use App\API\AlarmAPIs\AlertsInUA;
use App\AlarmHandler;
use App\Handlers\TelegramHandler;

require_once "settings.php";

consoleInfo("Working..");

$alarmHandler = new AlarmHandler();
$alarmHandler->setAlarmAPI(new AlertsInUA());
$alarmHandler->setHandler(new TelegramHandler());
$alarmHandler->work();

?>