<?php

namespace App\API\AlarmAPIs;

use App\API\APIAdapters\AlertsInUAAdapter;
use App\API\APIAdapters\APIAdapterInterface;
use Exception;

class AlertsInUA extends AbstractAlertsAPIs
{
    const URL = 'https://api.alerts.in.ua/v1/alerts/active.json';

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
                'Authorization: Bearer ' . $_ENV['ALERTS_IN_UA_TOKEN']
            ],
        ]);

        $response = curl_exec($curl);
        $httpStatus = curl_getinfo($curl, CURLINFO_HTTP_CODE);
        curl_close($curl);

        if ($httpStatus !== 200) {
            throw new Exception("Status: $httpStatus. " . $response);
        }

        if ($response === false) {
            throw new Exception('cURL error: ' . curl_error($curl));
        }

        return json_decode($response, true);
    }

    protected function getAdapter(array $APIData): APIAdapterInterface
    {
        return new AlertsInUAAdapter($APIData);
    }

    protected function filterAPIData(array $APIData): array
    {
        $APIData = $APIData['alerts'];
        $trackedLocationUIDs = json_decode($_ENV['LOCATION_UIDS'], true);

        return array_filter($APIData, function ($location) use ($trackedLocationUIDs) {
            return in_array($location['location_uid'], (array)$trackedLocationUIDs);
        });
    }
}