<?php

namespace App;

use App\AlarmAPIs\AlertsAPIsInterface;
use App\Handlers\HandlerInterface;

class AlarmHandler
{
    const CHECK_PERIOD_SEC = 30;
    private AlertsAPIsInterface $alarmAPI;

    /**
     * @var HandlerInterface[]
     */
    private array $handlers = [];

    public function setAlarmAPI(AlertsAPIsInterface $alarmAPI): void
    {
        $this->alarmAPI = $alarmAPI;
    }

    public function setHandler(HandlerInterface $handler)
    {
        $this->handlers[] = $handler;
    }

    public function work(): void
    {
        while (true) {
            $data = $this->alarmAPI->getData();
            foreach ($this->handlers as $handler) {
                $handler->setData($data)->doJob();
            }

            sleep(self::CHECK_PERIOD_SEC);
        }
    }
}