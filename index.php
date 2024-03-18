<?php

use App\API\AlarmAPIs\AlertsInUA;
use App\AlarmHandler;
use App\Handlers\TelegramHandler;
use App\Handlers\ViberHandler;

require_once "settings.php";

consoleText("Working...");

$alarmHandler = new AlarmHandler();
$alarmHandler->setAlarmAPI(new AlertsInUA());

$alarmHandler->setHandler(new TelegramHandler());
$alarmHandler->setHandler(new ViberHandler());

$alarmHandler->work();

?>