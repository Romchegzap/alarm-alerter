<?php

namespace App\Handlers;

use App\API\AlarmAPIs\AlarmStatus;
use App\DTO\LocationObject;
use App\Senders\SenderInterface;
use App\Senders\ViberSender;

class ViberHandler extends AbstractHandler
{
    protected function handlerName(): string
    {
        return 'Viber';
    }

    protected function hasAllEnvParams(): bool
    {
        return isset($_ENV['VIBER_AUTH_TOKEN'], $_ENV['VIBER_USER_ID']) &&
            $_ENV['VIBER_AUTH_TOKEN'] &&
            $_ENV['VIBER_USER_ID'];
    }

    //emojis available at https://decisiontele.com/news/620-emoji-viber-messaging-business-what-signs-choose-and-how-add-them-message-template-correctly.html not sure how to find other correct examples..
    protected function getMessage(LocationObject $locationObject): string
    {
        $locationTitle = $locationObject->title;

        return match ($locationObject->currentAlarmStatus) {
            AlarmStatus::ACTIVE => "(speaker) $locationTitle - повітряна тривога!",
            AlarmStatus::NOT_ACTIVE => "(speaker) $locationTitle - відбій повітряної тривоги!",
        };
    }

    protected function getSender(): SenderInterface
    {
        return new ViberSender();
    }

}