<?php

declare(strict_types=1);

namespace Talorvi\FeeCalculator\Contracts;

interface InterpolationStrategy
{
    public function interpolate(float $amount, array $feeStructure): float;
}
