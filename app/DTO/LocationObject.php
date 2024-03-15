<?php

namespace App\DTO;

use App\API\AlarmAPIs\AlarmStatus;

class LocationObject
{
    public int|string $location_id;
    public string $title;
    public AlarmStatus $previousAlarmStatus = AlarmStatus::NOT_ACTIVE;
    public AlarmStatus $currentAlarmStatus = AlarmStatus::NOT_ACTIVE;

    public function statusChanged(): bool
    {
        return $this->previousAlarmStatus !== $this->currentAlarmStatus;
    }
}