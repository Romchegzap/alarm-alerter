<?php

namespace App\APIAdapters;

use App\DTO\LocationObject;

abstract class AbstractAdapter implements APIAdapterInterface
{
    protected array $inputData;

    /**
     * @var LocationObject[]
     */
    protected array $outputData = [];

    abstract function convert(): void;

    public function __construct(array $inputData)
    {
        $this->inputData = $inputData;
    }

    /**
     * @return LocationObject[]
     */
    public function getOutputData(): array
    {
        $this->convert();
        return $this->outputData;
    }
}