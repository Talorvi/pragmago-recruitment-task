<?php

namespace Talorvi\FeeCalculator\Factories\Interpolations;

use Talorvi\FeeCalculator\Contracts\InterpolationStrategy;
use Talorvi\FeeCalculator\Enums\InterpolationType;

interface InterpolationStrategyFactoryInterface
{
    public function create(InterpolationType $type): InterpolationStrategy;
}