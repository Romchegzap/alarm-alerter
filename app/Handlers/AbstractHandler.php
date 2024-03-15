<?php

namespace App\Handlers;

use App\DTO\LocationObject;

abstract class AbstractHandler implements HandlerInterface
{
    /**
     * @var array<int|string, LocationObject>
     */
    protected array $locationsObjects = [];

    /**
     * @var LocationObject[]
     */
    protected array $inputLocationsObjects = [];

    /**
     * @param LocationObject[] $data
     * @return HandlerInterface
     */
    public function setData(array $data): HandlerInterface
    {
        $this->inputLocationsObjects = $data;
        return $this;
    }

    protected function fillIfEmpty(): void
    {
        foreach ($this->inputLocationsObjects as $inputLocationsObject) {
            $this->addObject($inputLocationsObject);
        }
    }

    protected function getObject($locationId): LocationObject
    {
        return $this->locationsObjects[$locationId];
    }

    protected function hasObject(LocationObject $inputLocationObject): bool
    {
        return isset($this->locationsObjects[$inputLocationObject->location_id]);
    }

    protected function updateObject(LocationObject $inputLocationObject): void
    {
        $object = $this->getObject($inputLocationObject->location_id);
        $object->currentAlarmStatus = $inputLocationObject->currentAlarmStatus;
    }

    protected function getInputLocationObjectsIDs(): array
    {
        $locationIds = [];

        foreach ($this->inputLocationsObjects as $object) {
            $locationIds[] = $object->location_id;
        }

        return $locationIds;
    }

    protected function addObject(LocationObject $inputLocationObject)
    {
        $this->locationsObjects[$inputLocationObject->location_id] = $inputLocationObject;
    }
}