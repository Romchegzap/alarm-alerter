FROM php:8.1-cli

WORKDIR /app

COPY . .

#Creating blank file to void issue with Dotenv\Dotenv
RUN touch .env

CMD [ "php", "./index.php" ]