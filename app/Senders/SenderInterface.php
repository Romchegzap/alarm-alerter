<?php

namespace App\Senders;

interface SenderInterface
{
    public function send(string $message): void;
}
