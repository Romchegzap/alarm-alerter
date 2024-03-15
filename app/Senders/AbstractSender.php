<?php

namespace App\Senders;

use App\AlarmAPIs\AlarmStatus;

abstract class AbstractSender implements SenderInterface
{
    protected AlarmStatus $lastAlarmStatus = AlarmStatus::NOT_ACTIVE;

    abstract protected function proceedSending(string $message): bool;

    public function send(AlarmStatus $newAlarmStatus, string $message): void
    {
        if ($this->lastAlarmStatus === $newAlarmStatus) {
            return;
        }

        if ($this->proceedSending($message)) {
            $this->lastAlarmStatus = $newAlarmStatus;
        }
    }
}