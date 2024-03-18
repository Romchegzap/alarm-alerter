<?php

namespace App\Handlers;

use App\API\AlarmAPIs\AlarmStatus;
use App\DTO\LocationObject;
use App\Senders\SenderInterface;
use App\Senders\TelegramSender;

class TelegramHandler extends AbstractHandler
{
    protected function handlerName(): string
    {
        return 'Telegram';
    }

    protected function hasAllEnvParams(): bool
    {
        return isset($_ENV['TELEGRAM_BOT_TOKEN'], $_ENV['TELEGRAM_CHAT_ID']) &&
            $_ENV['TELEGRAM_BOT_TOKEN'] &&
            $_ENV['TELEGRAM_CHAT_ID'];
    }

    //emojis available at https://apps.timwhitlock.info/emoji/tables/unicode
    protected function getMessage(LocationObject $locationObject): string
    {
        $locationTitle = $locationObject->title;

        return match ($locationObject->currentAlarmStatus) {
            AlarmStatus::ACTIVE => "&#128308; $locationTitle - повітряна тривога!",
            AlarmStatus::NOT_ACTIVE => "&#128994; $locationTitle - відбій повітряної тривоги!",
        };
    }

    protected function getSender(): SenderInterface
    {
        return new TelegramSender();
    }
}