<?php

declare(strict_types=1);

namespace App\Temperature;

use App\Entity\ExternalServiceCallResult;
use App\Exception\PlaceIsNotSupportedException;
use App\Exception\UnauthorizedExternalServiceException;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Contracts\HttpClient\HttpClientInterface;

final class WeatherServiceClient
{
    public function __construct(
        private HttpClientInterface $httpClient,
        private EntityManagerInterface $entityManager,
    ) {
    }

    /**
     * @throws PlaceIsNotSupportedException
     * @throws UnauthorizedExternalServiceException
     */
    public function requestForecast(string $url, array $parameters): array
    {
        $response = $this->httpClient
            ->request(Request::METHOD_GET, $url, [
                'query' => $parameters,
            ]);
        $statusCode = $response->getStatusCode();

        $externalServiceCallResult = new ExternalServiceCallResult(
            $url,
            $statusCode,
            $response->getContent(false)
        );
        $this->entityManager->persist($externalServiceCallResult);
        $this->entityManager->flush();

        if (\in_array($statusCode, [Response::HTTP_UNAUTHORIZED, Response::HTTP_FORBIDDEN], true)) {
            throw new UnauthorizedExternalServiceException(sprintf('%s endpoint authorization is failed. Please check api keys', $url));
        }

        if (Response::HTTP_OK !== $statusCode) {
            throw new PlaceIsNotSupportedException(sprintf('%s endpoint does not support provided place', $url));
        }

        return $response->toArray();
    }
}
