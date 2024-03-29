<?php

namespace App\API\APIAdapters;

use App\API\AlarmAPIs\AlarmStatus;
use App\DTO\LocationObject;

class AlertsInUAAdapter extends AbstractAdapter
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