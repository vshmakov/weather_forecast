<?php

declare(strict_types=1);

namespace App\Temperature;

use App\DTO\Place;

final class AverageTemperatureProvider implements TemperatureProviderInterface
{
    public function getTemperature(Place $place): int
    {
        return 32;
    }
}
