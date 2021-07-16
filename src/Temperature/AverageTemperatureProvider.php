<?php

declare(strict_types=1);

namespace App\Temperature;

use App\DTO\Place;
use Symfony\Component\DependencyInjection\Attribute\TaggedIterator;
use Webmozart\Assert\Assert;

final class AverageTemperatureProvider implements TemperatureProviderInterface
{
    public function __construct(
        #[TaggedIterator(TemperatureProviderInterface::EXTERNAL_SOURCE_TAG)] private iterable $temperatureProviders
    ) {
    }

    public function getTemperature(Place $place): float
    {
        /** @var TemperatureProviderInterface[] $providers */
        $providers = iterator_to_array($this->temperatureProviders);
        $count = \count($providers);
        Assert::notSame($count, 0, 'There is no temperature providers defined');
        $total = 0;

        foreach ($providers as $provider) {
            $total += $provider->getTemperature($place);
        }

        return round($total / $count);
    }
}
