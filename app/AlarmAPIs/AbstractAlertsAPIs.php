<?php

namespace App\AlarmAPIs;

use App\DTO\LocationObject;
use Throwable;

abstract class AbstractAlertsAPIs implements AlertsAPIsInterface
{
    /**
     * @var LocationObject[]
     */
    protected array $locationObjects = [];

    abstract protected function getAPIData(): array;

    abstract protected function findLocationObjects(array $APIData): void;

    public function proceed(): void
    {
        try {
            $APIData = $this->getAPIData();
            $this->findLocationObjects($APIData);
        } catch (Throwable $exception) {
            $message = $exception->getMessage();
            echo $message;

            $this->alarmStatus = null;
        }
    }

    public function getLocationObjects(): ?array
    {
        return $this->locationObjects;
    }
}

