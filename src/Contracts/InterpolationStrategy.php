<?php

declare(strict_types=1);

namespace Talorvi\FeeCalculator\Contracts;

interface InterpolationStrategy
{
    function interpolate(float $amount, array $feeStructure): float;
}
