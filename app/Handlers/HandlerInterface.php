<?php

namespace App\Handlers;

use App\DTO\LocationObject;

interface HandlerInterface
{
    /**
     * @param LocationObject[] $data
     * @return $this
     */
    public function setData(array $data): self;
    public function doJob(): void;
}