<?php

declare(strict_types=1);

namespace App\Temperature;

use App\DTO\Place;
use DateInterval;
use Psr\Cache\CacheItemPoolInterface;

final class CacheResultDecorator implements TemperatureProviderInterface
{
    public function __construct(
        private TemperatureProviderInterface $temperatureProvider,
        private CacheItemPoolInterface $cache,
    ) {
    }

    public function getTemperature(Place $place): float
    {
        $item = $this->cache->getItem(
            $this->getCacheKey($place)
        );

        if (!$item->isHit()) {
            $item->set(
                $this->temperatureProvider->getTemperature($place)
            );
            $item->expiresAfter(new DateInterval('PT5M'));
            $this->cache->save($item);
        }

        return $item->get();
    }

    private function getCacheKey(Place $place): string
    {
        return sprintf('place-temperature[country=%s, city=%s]', $place->country, $place->city);
    }
}
