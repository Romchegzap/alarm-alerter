<?php

namespace App;

use App\API\AlarmAPIs\AlertsAPIsInterface;
use App\Handlers\HandlerInterface;
use Throwable;

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
            try {
                $data = $this->alarmAPI->getData();
            } catch (Throwable $exception) {
                consoleDanger("ERROR: " . $exception->getMessage());
                sleep(self::CHECK_PERIOD_SEC);
                continue;
            }

            foreach ($this->handlers as $handler) {
                $handler->setData($data)->doJob();
            }

            consoleText('-------------------------------');

            sleep(self::CHECK_PERIOD_SEC);
        }
    }
}