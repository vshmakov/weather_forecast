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
        $temperatureList = array_map(
                    fn (TemperatureProviderInterface $temperatureProvider): float => $temperatureProvider->getTemperature($place),
            iterator_to_array($this->temperatureProviders)
                );

        return $this->getAverageTemperature($temperatureList);
    }

    private function getAverageTemperature(array $temperatureList): float
    {
        $count = \count($temperatureList);
        Assert::notSame($count, 0, 'You must define at least one temperature provider');

        return round(array_sum($temperatureList) / $count);
    }
}
