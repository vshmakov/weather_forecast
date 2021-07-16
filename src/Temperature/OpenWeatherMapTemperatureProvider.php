<?php

declare(strict_types=1);

namespace App\Temperature;

use App\DTO\Place;
use Symfony\Component\DependencyInjection\Attribute\AutoconfigureTag;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Contracts\HttpClient\HttpClientInterface;

#[AutoconfigureTag(TemperatureProviderInterface::EXTERNAL_SOURCE_TAG)]
final class OpenWeatherMapTemperatureProvider implements TemperatureProviderInterface
{
    public function __construct(
        private string $apiKey,
        private HttpClientInterface $httpClient
    ) {
    }

    public function getTemperature(Place $place): float
    {
        $r = $this->httpClient
            ->request(Request::METHOD_GET, 'https://api.openweathermap.org/data/2.5/weather', [
                'query' => [
                    'APPID' => $this->apiKey,
                    'q' => implode(',', [$place->city, $place->country]),
                    'units' => 'Metric',
                ],
            ]);
        $data = $r->toArray(false);
        $temperature = $data['main']['temp'];

        return $temperature;
    }
}
