<?php

declare(strict_types=1);

namespace App\Exception;

use App\DTO\Place;
use Exception;

final class PlaceIsNotSupportedException extends Exception
{
    public static function notSupportedByEndpoint(string $url, Place $place): self
    {
        return new self(sprintf(
            '%s endpoint does not support %s place',
            $temperatureProvider::class,
            json_encode($place, \JSON_UNESCAPED_UNICODE)
        ));
    }
}
