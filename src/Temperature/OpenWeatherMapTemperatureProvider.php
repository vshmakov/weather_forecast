<?php

declare(strict_types=1);

namespace App\Temperature;

use App\DTO\Place;
use Symfony\Component\DependencyInjection\Attribute\AutoconfigureTag;

#[AutoconfigureTag(TemperatureProviderInterface::EXTERNAL_SOURCE_TAG)]
final class OpenWeatherMapTemperatureProvider implements TemperatureProviderInterface
{
    public function __construct(
        private string $apiKey,
        private WeatherServiceClient $weatherServiceClient,
    ) {
    }

    public function getTemperature(Place $place): float
    {
        $forecast = $this->weatherServiceClient
            ->requestForecast('https://api.openweathermap.org/data/2.5/weather', [
                'APPID' => $this->apiKey,
                'q' => implode(',', [$place->city, $place->country]),
                'units' => 'Metric',
            ]);

        return $forecast['main']['temp'];
    }
}
