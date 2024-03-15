<?php

namespace App\AlarmAPIs;

use App\APIAdapters\AlertsInUAAdapter;
use App\APIAdapters\APIAdapterInterface;
use Exception;

class AlertsInUA extends AbstractAlertsAPIs
{
    const TOKEN = 'ab9cacdf5a808df5db00dc78afbd12775aa70b6fab2203';
    const URL = 'https://api.alerts.in.ua/v1/alerts/active.json';

    const REGION_IDS = [356];

    /**
     * @throws Exception
     */
    protected function fetchAPIData(): array
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

    protected function getAdapter(array $APIData): APIAdapterInterface
    {
        return new AlertsInUAAdapter($APIData);
    }

    protected function filterAPIData(array $APIData): array
    {
        $APIData = $APIData['alerts'];
        return array_filter($APIData, function ($location) {
            return in_array($location['location_uid'], self::REGION_IDS);
        });
    }
}