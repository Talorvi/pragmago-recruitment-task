<?php

declare(strict_types=1);

namespace Talorvi\FeeCalculator\Services;

use InvalidArgumentException;
use Talorvi\FeeCalculator\Contracts\InterpolationStrategy;
use Talorvi\FeeCalculator\Contracts\RoundingStrategy;
use Talorvi\FeeCalculator\Enums\InterpolationType;
use Talorvi\FeeCalculator\Enums\LoanTerm;
use Talorvi\FeeCalculator\Enums\RoundingType;
use Talorvi\FeeCalculator\Factories\Interpolations\InterpolationStrategyFactoryInterface;
use Talorvi\FeeCalculator\Factories\Roundings\RoundingStrategyFactoryInterface;
use Talorvi\FeeCalculator\Models\LoanProposal;
use Talorvi\FeeCalculator\Repositories\ArrayFeeStructureRepository;

class FeeCalculatorService
{
    private ArrayFeeStructureRepository $arrayFeeStructureRepository;
    private InterpolationStrategy $interpolationStrategy;
    private RoundingStrategy $roundingStrategy;

    public function __construct(
        ArrayFeeStructureRepository           $arrayFeeStructureRepository,
        InterpolationStrategyFactoryInterface $interpolationFactory,
        RoundingStrategyFactoryInterface      $roundingFactory
    ) {
        $this->arrayFeeStructureRepository = $arrayFeeStructureRepository;
        $this->interpolationStrategy = $interpolationFactory->create(InterpolationType::LINEAR);
        $this->roundingStrategy = $roundingFactory->create(RoundingType::ROUND_UP_TO_FIVE);
    }

    public function calculate(LoanProposal $application): float
    {
        $term = LoanTerm::tryFrom($application->term());
        if ($term === null) {
            throw new InvalidArgumentException('Invalid term provided.');
        }

        $feeStructure = $this->arrayFeeStructureRepository->getFeesForTerm($term);
        $interpolatedFee = $this->interpolationStrategy->interpolate($application->amount(), $feeStructure);
        return $this->roundingStrategy->round($interpolatedFee, $application->amount());
    }
}
