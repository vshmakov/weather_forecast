<?php

declare(strict_types=1);

namespace App\Temperature;

use App\DTO\Place;
use Webmozart\Assert\Assert;

final class AverageTemperatureProvider implements TemperatureProviderInterface
{
    public function __construct(private iterable $temperatureProviders)
    {
    }

    public function getTemperature(Place $place): int
    {
        $providers = iterator_to_array($this->temperatureProviders);
        $count = \count($providers);
        Assert::notSame($count, 0, 'There is no temperature providers defined');
        $total = 0;

        /** @var TemperatureProviderInterface $provider */
        foreach ($providers as $provider) {
            $total += $provider->getTemperature($place);
        }

        return round($total / $count);
    }
}
