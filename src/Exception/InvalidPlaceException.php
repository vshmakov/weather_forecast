<?php

declare(strict_types=1);

namespace App\Exception;

use App\DTO\Place;
use App\Temperature\TemperatureProviderInterface;
use Exception;

final class InvalidPlaceException extends Exception
{
    public static function notSupportedByTemperatureProvider(TemperatureProviderInterface $temperatureProvider, Place $place): self
    {
        return new self(sprintf(
            '%s provider does not support %s place',
            $temperatureProvider::class,
            json_encode($place, \JSON_UNESCAPED_UNICODE)
        ));
    }
}
