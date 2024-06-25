<?php

namespace Talorvi\FeeCalculator\Factories\Roundings;

use Talorvi\FeeCalculator\Contracts\RoundingStrategy;
use Talorvi\FeeCalculator\Enums\RoundingType;

interface RoundingStrategyFactoryInterface
{
    public function create(RoundingType $type): RoundingStrategy;
}