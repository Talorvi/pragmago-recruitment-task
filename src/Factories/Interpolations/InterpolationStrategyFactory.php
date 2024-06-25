<?php

namespace Talorvi\FeeCalculator\Factories\Interpolations;

use Talorvi\FeeCalculator\Contracts\InterpolationStrategy;
use Talorvi\FeeCalculator\Enums\InterpolationType;
use Talorvi\FeeCalculator\Strategies\Interpolations\LinearInterpolationStrategy;

class InterpolationStrategyFactory implements InterpolationStrategyFactoryInterface
{
    public function create(InterpolationType $type): InterpolationStrategy
    {
        return match($type) {
            InterpolationType::LINEAR => new LinearInterpolationStrategy(),
            default => throw new \InvalidArgumentException("Unsupported interpolation type")
        };
    }
}