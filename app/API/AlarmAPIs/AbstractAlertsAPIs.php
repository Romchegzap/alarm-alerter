<?php

namespace App\API\AlarmAPIs;

use App\API\APIAdapters\APIAdapterInterface;
use App\DTO\LocationObject;

abstract class AbstractAlertsAPIs implements AlertsAPIsInterface
{
    abstract protected function fetchAPIData(): array;

    abstract protected function getAdapter(array $APIData): APIAdapterInterface;

    /**
     * @return LocationObject[]
     */
    public function getData(): array
    {
        consoleText("Getting data by " . static::class . "...");

        $APIData = $this->fetchAPIData();

        consoleSuccess("Data fetched successfully.");

        $APIData = $this->filterAPIData($APIData);
        $adapter = $this->getAdapter($APIData);
        return $adapter->getOutputData();
    }

    protected function filterAPIData(array $APIData): array
    {
        return $APIData;
    }
}

