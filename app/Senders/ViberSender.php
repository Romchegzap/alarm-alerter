<?php

namespace App\Senders;

use Exception;

class ViberSender extends AbstractSender
{
    public function proceedSending(string $message): void
    {
        $postData = json_encode([
            "auth_token" => $_ENV['VIBER_AUTH_TOKEN'],
            "from"       => $_ENV['VIBER_USER_ID'],
            "type"       => "text",
            "text"       => $message
        ]);

        $curl = curl_init();

        curl_setopt_array($curl, [
            CURLOPT_URL            => "https://chatapi.viber.com/pa/post",
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_TIMEOUT        => 15,
            CURLOPT_HTTP_VERSION   => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST  => "POST",
            CURLOPT_POSTFIELDS     => $postData,
        ]);

        $response = curl_exec($curl);
        $httpStatus = curl_getinfo($curl, CURLINFO_HTTP_CODE);
        curl_close($curl);

        if ($httpStatus !== 200) {
            throw new Exception('Sending failed, status:' . $httpStatus);
        }
    }
}