<?php

declare(strict_types=1);

namespace Talorvi\FeeCalculator\Contracts;

interface RoundingStrategy
{
    public function round(float $fee, float $amount): float;
}
