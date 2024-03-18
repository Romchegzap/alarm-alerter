<?php

namespace App\Handlers;

use App\API\AlarmAPIs\AlarmStatus;
use App\DTO\LocationObject;
use App\Senders\SenderInterface;
use Throwable;

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

    abstract protected function handlerName(): string;

    abstract protected function hasAllEnvParams(): bool;

    abstract protected function getMessage(LocationObject $locationObject): string;

    abstract protected function getSender(): SenderInterface;

    /**
     * @param LocationObject[] $data
     * @return HandlerInterface
     */
    public function setData(array $data): HandlerInterface
    {
        $this->inputLocationsObjects = $data;
        return $this;
    }

    public function doJob(): void
    {
        $handlerName = $this->handlerName();
        consoleInfo("Handling $handlerName");

        if ($this->missEnvParam()) {
            consoleWarning("Environment parameters were not configured for $handlerName.. skipping..");
            return;
        }

        $this->handleInputData();
        $this->handleSending();
    }

    protected function missEnvParam(): bool
    {
        return !$this->hasAllEnvParams();
    }

    protected function handleInputData(): void
    {
        if (!$this->locationsObjects) {
            $this->fillIfEmpty();
            return;
        }

        $this->handleInputActive();
        $this->handleInputNotActive();
    }

    protected function handleInputActive(): void
    {
        foreach ($this->inputLocationsObjects as $inputObject) {
            if ($this->hasObject($inputObject)) {
                $this->updateObject($inputObject);
                continue;
            }

            $this->addObject($inputObject);
        }
    }

    protected function handleInputNotActive(): void
    {
        $inputLocationObjectsIDs = $this->getInputLocationObjectsIDs();

        $locationIDs = array_diff(array_keys($this->locationsObjects), $inputLocationObjectsIDs);

        foreach ($locationIDs as $locationID) {
            $object = $this->getObject($locationID);
            $object->currentAlarmStatus = AlarmStatus::NOT_ACTIVE;
        }
    }

    protected function handleSending(): void
    {
        foreach ($this->locationsObjects as $locationObject) {
            if ($locationObject->statusChanged()) {
                try {
                    $handlerName = $this->handlerName();
                    consoleWarning("Sending to $handlerName. Message: " . $this->getMessage($locationObject));
                    $this->getSender()->send($this->getMessage($locationObject));
                    consoleSuccess('Sent successfully.');
                    $locationObject->previousAlarmStatus = $locationObject->currentAlarmStatus;
                } catch (Throwable $exception) {
                    consoleDanger('ERROR while sending: ' . $exception->getMessage());
                }
            } else {
                consoleText("Status of $locationObject->title didnt change.");
            }
        }
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

    protected function addObject(LocationObject $inputLocationObject): void
    {
        $this->locationsObjects[$inputLocationObject->location_id] = clone $inputLocationObject;
    }
}