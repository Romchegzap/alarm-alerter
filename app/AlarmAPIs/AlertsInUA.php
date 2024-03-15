<?php

namespace App\AlarmAPIs;

use App\DTO\LocationObject;
use Exception;

class AlertsInUA extends AbstractAlertsAPIs
{
    const TOKEN = 'ab9cacdf5a808df5db00dc78afbd12775aa70b6fab2203';
    const URL = 'https://api.alerts.in.ua/v1/alerts/active.json';
//    const REGION_ID = 12;
    const REGION_TITLE = 'Чернігівська область';
    const REGION_ID = 25;

    const REGION_IDS = [25];

    const FIND_DATA = [
        25 => 'Чернігівська область'
    ];

    /**
     * @throws Exception
     */
    protected function getAPIData(): array
    {
        $curl = curl_init();

        curl_setopt_array($curl, [
            CURLOPT_URL            => self::URL,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING       => "",
            CURLOPT_MAXREDIRS      => 10,
            CURLOPT_TIMEOUT        => 10,
            CURLOPT_HTTP_VERSION   => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST  => "GET",
            CURLOPT_HTTPHEADER     => [
                'Authorization: Bearer ' . self::TOKEN
            ],
        ]);

        $response = curl_exec($curl);

        if ($response === false) {
            throw new Exception('Ошибка cURL: ' . curl_error($curl));
        }

        curl_close($curl);
        return json_decode($response, true);
    }

    protected function findLocationObjects(array $APIData): void
    {
        foreach ($APIData['alerts'] as $alert) {
            if (in_array(self::REGION_IDS, $alert['location_uid'])) {

                if (!isset($this->locationObjects[$alert['location_uid']])) {
                    $object = new LocationObject();
                    $object->id = $alert['location_uid'];
                    $object->title = $alert['location_title'];
                    $object->previousAlarmStatus = AlarmStatus::NOT_ACTIVE;
                    $object->currentAlarmStatus = AlarmStatus::ACTIVE;

                    $this->locationObjects[$alert['location_uid']] = $object;
                    continue;
                }

                $locationObject = $this->locationObjects[$alert['location_uid']];
                $locationObject->previousAlarmStatus = $locationObject->currentAlarmStatus;
                $locationObject->currentAlarmStatus = AlarmStatus::ACTIVE;
            }
        }
    }
}