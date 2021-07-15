<?php

declare(strict_types=1);

namespace App\Temperature;

use App\DTO\Place;

interface TemperatureProviderInterface
{
    public function getTemperature(Place $place): int;
}
