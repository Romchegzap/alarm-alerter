<?php

namespace App\Senders;


abstract class AbstractSender implements SenderInterface
{
    abstract protected function proceedSending(string $message): void;

    public function send(string $message): void
    {
        $this->proceedSending($message);
    }
}