<?php

namespace App\Senders;

use App\AlarmAPIs\AlarmStatus;

interface SenderInterface
{
    public function send(AlarmStatus $newAlarmStatus, string $message): void;
}
