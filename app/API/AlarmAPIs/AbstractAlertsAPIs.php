<?php

namespace App\API\AlarmAPIs;

use App\API\APIAdapters\APIAdapterInterface;
use App\DTO\LocationObject;
use Throwable;

abstract class AbstractAlertsAPIs implements AlertsAPIsInterface
{
    abstract protected function fetchAPIData(): array;

    abstract protected function getAdapter(array $APIData): APIAdapterInterface;

    /**
     * @return LocationObject[]
     */
    public function getData(): array
    {
        try {
            $APIData = $this->fetchAPIData();
            $APIData = $this->filterAPIData($APIData);
            $adapter = $this->getAdapter($APIData);
            return $adapter->getOutputData();
        } catch (Throwable $exception) {
            var_dump($exception->getMessage());
            return [];
        }
    }

    protected function filterAPIData(array $APIData): array
    {
        return $APIData;
    }
}

