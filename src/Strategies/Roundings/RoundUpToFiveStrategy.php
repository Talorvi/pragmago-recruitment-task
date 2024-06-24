<?php

declare(strict_types=1);

namespace Talorvi\FeeCalculator\Strategies\Roundings;

use Talorvi\FeeCalculator\Contracts\RoundingStrategy;

class RoundUpToFiveStrategy implements RoundingStrategy
{
    public function round(float $fee, float $amount): float
    {
        return ceil(($fee + $amount) / 5) * 5 - $amount;
    }
}
