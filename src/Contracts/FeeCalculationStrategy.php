<?php

declare(strict_types=1);

namespace Talorvi\FeeCalculator\Contracts;

interface FeeCalculationStrategy
{
    public function __construct(
        FeeStructureRepository $feeStructureRepository,
        InterpolationStrategy  $interpolationStrategy,
        RoundingStrategy       $roundingStrategy
    );

    public function calculate(float $amount): float;
}
