<?php

namespace Talorvi\FeeCalculator\Factories\Roundings;

use Talorvi\FeeCalculator\Contracts\RoundingStrategy;
use Talorvi\FeeCalculator\Enums\RoundingType;
use Talorvi\FeeCalculator\Strategies\Roundings\RoundUpToFiveStrategy;

class RoundingStrategyFactory implements RoundingStrategyFactoryInterface
{
    public function create(RoundingType $type): RoundingStrategy
    {
        return match($type) {
            RoundingType::ROUND_UP_TO_FIVE => new RoundUpToFiveStrategy(),
            default => throw new \InvalidArgumentException("Unsupported rounding type")
        };
    }
}