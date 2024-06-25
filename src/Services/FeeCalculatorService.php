<?php

declare(strict_types=1);

namespace Talorvi\FeeCalculator\Services;

use InvalidArgumentException;
use Talorvi\FeeCalculator\Contracts\InterpolationStrategy;
use Talorvi\FeeCalculator\Contracts\RoundingStrategy;
use Talorvi\FeeCalculator\Enums\LoanTerm;
use Talorvi\FeeCalculator\Models\LoanProposal;
use Talorvi\FeeCalculator\Repositories\ArrayFeeStructureRepository;

class FeeCalculatorService
{
    private ArrayFeeStructureRepository $arrayFeeStructureRepository;
    private InterpolationStrategy $interpolationStrategy;
    private RoundingStrategy $roundingStrategy;

    public function __construct(
        ArrayFeeStructureRepository $arrayFeeStructureRepository,
        InterpolationStrategy $interpolationStrategy,
        RoundingStrategy $roundingStrategy
    ) {
        $this->roundingStrategy = $roundingStrategy;
        $this->interpolationStrategy = $interpolationStrategy;
        $this->arrayFeeStructureRepository = $arrayFeeStructureRepository;

    }

    public function calculate(LoanProposal $application): float
    {
        $term = LoanTerm::tryFrom($application->term());

        if ($term === null) {
            throw new InvalidArgumentException();
        }

        $term = LoanTerm::tryFrom($application->term());
        $feeStructure = $this->arrayFeeStructureRepository->getFeesForTerm($term);
        $interpolatedFee = $this->interpolationStrategy->interpolate($application->amount(), $feeStructure);
        return $this->roundingStrategy->round($interpolatedFee, $application->amount());
    }
}
