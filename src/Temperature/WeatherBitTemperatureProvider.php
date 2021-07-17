<?php

declare(strict_types=1);

namespace App\Temperature;

use App\DTO\Place;
use Symfony\Component\DependencyInjection\Attribute\AutoconfigureTag;

#[AutoconfigureTag(TemperatureProviderInterface::EXTERNAL_SOURCE_TAG)]
final class WeatherBitTemperatureProvider implements TemperatureProviderInterface
{
    public function __construct(
        private string $apiKey,
        private WeatherServiceClient $weatherServiceClient,
    ) {
    }

    public function getTemperature(Place $place): float
    {
        $forecast = $this->weatherServiceClient
            ->requestForecast('https://api.weatherbit.io/v2.0/current', [
                'key' => $this->apiKey,
                'city' => $place->city,
                'country' => $place->country,
            ]);

        return $forecast['data'][0]['temp'];
    }
}
