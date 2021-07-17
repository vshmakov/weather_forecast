<?php

declare(strict_types=1);

namespace App\Temperature;

use App\DTO\Place;
use App\Exception\InvalidPlaceException;

interface TemperatureProviderInterface
{
    public const EXTERNAL_SOURCE_TAG = 'temperature.external.source.provider';

    /**
     * @throws InvalidPlaceException
     */
    public function getTemperature(Place $place): float;
}
