<?php

namespace App\AlarmAPIs;

interface AlertsAPIsInterface {
    public function proceed(): void;
    public function getLocationObjects(): ?array;
}