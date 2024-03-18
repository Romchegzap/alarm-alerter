# Alarm Alerter

###Setup alerts.in.ua API:

- go to https://alerts.in.ua/api-request and get TOKEN
- set ALERTS_IN_UA_TOKEN variable in docker-composer.yaml
- application fetching active alarms from https://api.alerts.in.ua/v1/alerts/active.json?token=<YOUR_TOKEN> route and filtering by location_uid property. So set LOCATION_UIDS(json array) according to location_uid

###Setup Telegram:

- create Telegram Bot. Find @BotFather and follow instructions there to create new Bot
- set TELEGRAM_BOT_TOKEN(from previous step) variable in docker-composer.yaml
- add Bot to your channel as administrator
- find chat_id of your channel at https://t.me/username_to_id_bot and set it to TELEGRAM_CHAT_ID variable in docker-composer.yaml
- set messages TelegramHandler.php in method getMessage()

Telegram setup is done.

###Setup Viber: 
Use this documentation(https://developers.viber.com/docs/tools/channels-post-api) to get all variables for the Viber API
- find your VIBER_AUTH_TOKEN from Viber Channel and set to docker-compose.yml
- use https://chatapi.viber.com/pa/set_webhook to set a webhook


    {
        "url":"https://my.host.com",
        "auth_token":"your_auth_token"
    }

read documentation I mentioned above
- make this POST request https://chatapi.viber.com/pa/get_account_info 


    {
        "auth_token":"your_auth_token"
    }


Find your user id in response and set it to VIBER_USER_ID

Viber setup is done.

##Application

To start alarm-alerter:

    docker compose up

or add -d to run in background

    docker compose run -d