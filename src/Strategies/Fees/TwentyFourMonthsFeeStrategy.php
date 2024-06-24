<?php

declare(strict_types=1);

namespace Talorvi\FeeCalculator\Strategies\Fees;

use Talorvi\FeeCalculator\Contracts\FeeCalculationStrategy;
use Talorvi\FeeCalculator\Contracts\FeeStructureRepository;
use Talorvi\FeeCalculator\Contracts\InterpolationStrategy;
use Talorvi\FeeCalculator\Contracts\RoundingStrategy;

class TwentyFourMonthsFeeStrategy implements FeeCalculationStrategy
{
    private FeeStructureRepository $feeStructureRepository;
    private InterpolationStrategy $interpolationStrategy;
    private RoundingStrategy $roundingStrategy;

    public function __construct(
        FeeStructureRepository $feeStructureRepository,
        InterpolationStrategy  $interpolationStrategy,
        RoundingStrategy       $roundingStrategy
    )
    {
        $this->feeStructureRepository = $feeStructureRepository;
        $this->interpolationStrategy = $interpolationStrategy;
        $this->roundingStrategy = $roundingStrategy;
    }

    public function calculate(float $amount): float
    {
        $feeStructure = $this->feeStructureRepository->getFeesForTerm(24);
        $interpolatedFee = $this->interpolationStrategy->interpolate($amount, $feeStructure);
        return $this->roundingStrategy->round($interpolatedFee, $amount);
    }
}
