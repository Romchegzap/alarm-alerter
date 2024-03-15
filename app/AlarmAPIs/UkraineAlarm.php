<?php

namespace App\AlarmAPIs;

class UkraineAlarm extends AbstractAlertsAPIs
{
    const TOKEN = 'YOUR_APP_TOKEN';
    const URL = 'https://air-alarm-ukraine.p.rapidapi.com/statuses.json';

    protected function getAPIData(): array
    {
        $curl = curl_init();

        curl_setopt_array($curl, [
            CURLOPT_URL            => "https://air-alarm-ukraine.p.rapidapi.com/statuses.json",
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING       => "",
            CURLOPT_MAXREDIRS      => 10,
            CURLOPT_TIMEOUT        => 30,
            CURLOPT_HTTP_VERSION   => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST  => "GET",
            CURLOPT_HTTPHEADER     => [
                "X-RapidAPI-Host: air-alarm-ukraine.p.rapidapi.com",
                "X-RapidAPI-Key: SIGN-UP-FOR-KEY"
            ],
        ]);

        $response = curl_exec($curl);

        if ($response === false) {
            throw new Exception('Ошибка cURL: ' . curl_error($curl));
        }

        curl_close($curl);
        return json_decode($response, true);
    }

    protected function handleAPIData(array $APIData): AlarmStatus
    {
        // TODO: Implement handleAPIData() method.

        return AlarmStatus::NOT_ACTIVE;
    }
}