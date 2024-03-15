<?php

namespace App\APIAdapters;

use App\AlarmAPIs\AlarmStatus;
use App\DTO\LocationObject;

class AlertsInUADataAdapter extends AbstractAdapter
{
    public function convert(): void
    {
        foreach($this->inputData as $alert) {
            $object = new LocationObject();
            $object->location_id = $alert['location_uid'];
            $object->title = $alert['location_title'];
            $object->currentAlarmStatus = AlarmStatus::ACTIVE;

            $this->outputData[] = $object;
        }
    }
}