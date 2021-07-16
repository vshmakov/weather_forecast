<?php

declare(strict_types=1);

namespace App\Temperature;

use App\DTO\Place;
use Symfony\Component\DependencyInjection\Attribute\AutoconfigureTag;

#[AutoconfigureTag(TemperatureProviderInterface::EXTERNAL_SOURCE_TAG)]
final class OpenWeatherMapTemperatureProvider implements TemperatureProviderInterface
{
    public function getTemperature(Place $place): int
    {
        return 32;
    }
}
