<?php

declare(strict_types=1);

namespace App\Temperature;

use App\DTO\Place;

interface TemperatureProviderInterface
{
    public const EXTERNAL_SOURCE_TAG = 'temperature.external.source.provider';

    public function getTemperature(Place $place): float;
}
