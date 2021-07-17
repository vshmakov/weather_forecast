<?php

declare(strict_types=1);

namespace App\Temperature;

use App\DTO\Place;
use App\Entity\ExternalServiceCallResult;
use App\Exception\InvalidPlaceException;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\DependencyInjection\Attribute\AutoconfigureTag;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Contracts\HttpClient\HttpClientInterface;

#[AutoconfigureTag(TemperatureProviderInterface::EXTERNAL_SOURCE_TAG)]
final class OpenWeatherMapTemperatureProvider implements TemperatureProviderInterface
{
    public function __construct(
        private string $apiKey,
        private HttpClientInterface $httpClient,
        private EntityManagerInterface $entityManager,
    ) {
    }

    public function getTemperature(Place $place): float
    {
        $response = $this->httpClient
            ->request(Request::METHOD_GET, 'https://api.openweathermap.org/data/2.5/weather', [
                'query' => [
                    'APPID' => $this->apiKey,
                    'q' => implode(',', [$place->city, $place->country]),
                    'units' => 'Metric',
                ],
            ]);

        $statusCode = $response->getStatusCode();
        $externalServiceCallResult = new ExternalServiceCallResult(
            $statusCode,
            $response->getContent(false)
        );
        $this->entityManager->persist($externalServiceCallResult);
        $this->entityManager->flush();

        if (Response::HTTP_OK !== $statusCode) {
            throw InvalidPlaceException::notSupportedByTemperatureProvider($this, $place);
        }

        $data = $response->toArray(false);
        $temperature = $data['main']['temp'];

        return $temperature;
    }
}
