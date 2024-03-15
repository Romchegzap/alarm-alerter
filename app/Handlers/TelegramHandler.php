<?php

namespace App\Handlers;

use App\AlarmAPIs\AlarmStatus;
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

        foreach ($this->inputLocationsObjects as $object) {
            if ($this->hasObject($object)) {
                $this->updateObject($object);
                continue;
            }

            $this->addObject($object);
        }
    }

    private function handleSending(): void
    {
        foreach($this->locationsObjects as $locationObject) {
            if ($locationObject->statusChanged()) {
                try {
                    $this->getSender()->send($this->getMessage($locationObject));
                    $locationObject->previousAlarmStatus = $locationObject->currentAlarmStatus;
                } catch (Throwable $exception) {
                    var_dump($exception->getMessage());
                }
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