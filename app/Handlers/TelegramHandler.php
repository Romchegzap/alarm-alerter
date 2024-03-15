<?php

namespace App\Handlers;

use App\API\AlarmAPIs\AlarmStatus;
use App\DTO\LocationObject;
use App\Senders\SenderInterface;
use App\Senders\TelegramSender;
use Throwable;

class TelegramHandler extends AbstractHandler
{
    public function doJob(): void
    {
        $this->handleInputData();
        $this->handleSending();
    }

    public function handleInputData(): void
    {
        if (!$this->locationsObjects) {
            $this->fillIfEmpty();
            return;
        }

        $this->handleInputActive();
        $this->handleInputNotActive();
    }

    private function handleInputActive(): void
    {
        foreach ($this->inputLocationsObjects as $object) {
            if ($this->hasObject($object)) {
                $this->updateObject($object);
                continue;
            }

            $this->addObject($object);
        }
    }

    private function handleInputNotActive()
    {
        $inputLocationObjectsIDs = $this->getInputLocationObjectsIDs();

        $locationIDs = array_diff(array_keys($this->locationsObjects), $inputLocationObjectsIDs);

        foreach ($locationIDs as $locationID) {
            $object = $this->getObject($locationID);
            $object->currentAlarmStatus = AlarmStatus::NOT_ACTIVE;
        }
    }

    private function handleSending(): void
    {
        foreach ($this->locationsObjects as $locationObject) {
            if ($locationObject->statusChanged()) {
                try {
                    consoleWarning('Sending to Telegram. Message: ' . $this->getMessage($locationObject));
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

    //emojis available at https://apps.timwhitlock.info/emoji/tables/unicode
    private function getMessage(LocationObject $locationObject): string
    {
        $locationTitle = $locationObject->title;

        return match ($locationObject->currentAlarmStatus) {
            AlarmStatus::ACTIVE => "&#128308; $locationTitle - повітряна тривога!",
            AlarmStatus::NOT_ACTIVE => "&#128994; $locationTitle - відбій повітряної тривоги!",
        };
    }

    private function getSender(): SenderInterface
    {
        return new TelegramSender();
    }


}