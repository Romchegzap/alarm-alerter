<?php

namespace App\APIAdapters;

use App\DTO\LocationObject;

interface APIDataAdapterInterface
{
    /**
     * @return LocationObject[]
     */
    public function getOutputData(): array;
}