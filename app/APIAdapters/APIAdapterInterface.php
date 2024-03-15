<?php

namespace App\APIAdapters;

use App\DTO\LocationObject;

interface APIAdapterInterface
{
    /**
     * @return LocationObject[]
     */
    public function getOutputData(): array;
}