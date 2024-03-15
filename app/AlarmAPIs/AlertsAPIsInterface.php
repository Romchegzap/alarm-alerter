<?php

namespace App\AlarmAPIs;

use App\DTO\LocationObject;

interface AlertsAPIsInterface {
    /**
     * @return LocationObject[]
     */
    public function getData(): array;
}