<?php

namespace App\Senders;

use App\AlarmAPIs\AlarmStatus;

class TelegramSender extends AbstractSender
{
    const BOT_TOKEN = "7161232939:AAHFjh8uYEX3EkBG9Uz_w0jQTQ8VvPKE33U";
    const CHAT_ID = -4179215532;

    protected function getMessage(AlarmStatus $alarmStatus): string
    {
        $locationTitle = $this->data['location_title'];

        return match ($alarmStatus) {
            AlarmStatus::ACTIVE => "🔴 $locationTitle - повітряна тривога!",
            AlarmStatus::NOT_ACTIVE => "🟢 $locationTitle - відбій повітряної тривоги!",
        };
    }

    public function proceedSending(string $message): bool
    {
        $getQuery = array(
            "chat_id"    => self::CHAT_ID,
            "text"       => $message,
            "parse_mode" => "html"
        );

        $curl = curl_init();

        curl_setopt_array($curl, [
            CURLOPT_URL            => "https://api.telegram.org/bot" . self::BOT_TOKEN . "/sendMessage?" . http_build_query($getQuery),
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_TIMEOUT        => 15,
            CURLOPT_HTTP_VERSION   => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST  => "GET",
        ]);

        curl_exec($curl);
        $httpStatus = curl_getinfo($curl, CURLINFO_HTTP_CODE);
        curl_close($curl);

        return $httpStatus === 200;
    }
}