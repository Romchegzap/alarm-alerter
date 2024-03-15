<?php

namespace App\API\AlarmAPIs;

use App\DTO\LocationObject;

interface AlertsAPIsInterface {
    /**
     * @return LocationObject[]
     */
    public function getData(): array;
}