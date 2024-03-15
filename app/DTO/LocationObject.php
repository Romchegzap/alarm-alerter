<?php

namespace App\DTO;

use App\AlarmAPIs\AlarmStatus;

class LocationObject
{
    public int|string $id;
    public string $title;
    public ?AlarmStatus $previousAlarmStatus;
    public ?AlarmStatus $currentAlarmStatus;
}