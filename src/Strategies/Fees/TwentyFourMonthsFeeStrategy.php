<?php

declare(strict_types=1);

namespace Talorvi\FeeCalculator\Strategies\Fees;

use Talorvi\FeeCalculator\Contracts\FeeCalculationStrategy;
use Talorvi\FeeCalculator\Contracts\InterpolationStrategy;
use Talorvi\FeeCalculator\Contracts\RoundingStrategy;

class TwentyFourMonthsFeeStrategy implements FeeCalculationStrategy
{
    private array $feeStructure;
    private InterpolationStrategy $interpolationStrategy;
    private RoundingStrategy $roundingStrategy;

    public function __construct(
        array $feeStructure,
        InterpolationStrategy  $interpolationStrategy,
        RoundingStrategy       $roundingStrategy
    )
    {
        $this->feeStructure = $feeStructure;
        $this->interpolationStrategy = $interpolationStrategy;
        $this->roundingStrategy = $roundingStrategy;
    }

    public function calculate(float $amount): float
    {
        $feeStructure = $this->feeStructure;
        $interpolatedFee = $this->interpolationStrategy->interpolate($amount, $feeStructure);
        return $this->roundingStrategy->round($interpolatedFee, $amount);
    }
}
