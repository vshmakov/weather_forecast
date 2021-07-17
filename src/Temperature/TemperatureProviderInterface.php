<?php

declare(strict_types=1);

namespace App\Temperature;

use App\DTO\Place;
use App\Exception\PlaceIsNotSupportedException;

interface TemperatureProviderInterface
{
    public const EXTERNAL_SOURCE_TAG = 'temperature.external.source.provider';

    /**
     * @throws PlaceIsNotSupportedException
     */
    public function getTemperature(Place $place): float;
}
