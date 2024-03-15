<?php

namespace App;

use App\AlarmAPIs\AlertsAPIsInterface;
use App\Senders\SenderInterface;
use TelegramService;

class AlarmHandler
{
    const CHECK_PERIOD_SEC = 30;
    private AlertsAPIsInterface $alarmAPI;

    /**
     * @var SenderInterface[]
     */
    private array $senders = [];

    public function setAlarmAPI(AlertsAPIsInterface $alarmAPI)
    {
        $this->alarmAPI = $alarmAPI;
    }

    public function setSender(SenderInterface $sender)
    {
        $this->senders[] = $sender;
    }

    public function work(): void
    {
        $telegramService = new TelegramService();

        foreach (range(1, 2) as $v) {
//        while (true) {
            $this->alarmAPI->proceed();
            $relatedData = $this->alarmAPI->getLocationObjects();
            $newAlarmStatus = $this->alarmAPI->isAlarmActive();

            if (is_null($newAlarmStatus)) {
                sleep(self::CHECK_PERIOD_SEC);
                continue;
            }

            $telegramService->
            $a = (new TelegramService($relatedData, $newAlarmStatus));

//            foreach ($this->senders as $sender) {
//                $sender->send($newAlarmStatus, $message);
//            }

            sleep(self::CHECK_PERIOD_SEC);
        }
    }
}