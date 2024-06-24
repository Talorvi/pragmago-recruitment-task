<?php

declare(strict_types=1);

namespace Talorvi\FeeCalculator\Factories;

use Talorvi\FeeCalculator\Contracts\FeeCalculationStrategy;
use Talorvi\FeeCalculator\Contracts\FeeStructureRepository;
use Talorvi\FeeCalculator\Enums\LoanTerm;
use Talorvi\FeeCalculator\Strategies\Fees\TwelveMonthsFeeStrategy;
use Talorvi\FeeCalculator\Strategies\Fees\TwentyFourMonthsFeeStrategy;
use Talorvi\FeeCalculator\Strategies\Interpolations\LinearInterpolationStrategy;
use Talorvi\FeeCalculator\Strategies\Roundings\RoundUpToFiveStrategy;

class FeeStrategyFactory
{
    private FeeStructureRepository $feeStructureRepository;

    public function __construct(FeeStructureRepository $feeStructureRepository)
    {
        $this->feeStructureRepository = $feeStructureRepository;
    }

    public function getStrategy(int $term): FeeCalculationStrategy
    {
        $loanTerm = LoanTerm::tryFrom($term);

        if (null === $loanTerm) {
            throw new \InvalidArgumentException("Unsupported loan term: $term");
        }

        $interpolationStrategy = new LinearInterpolationStrategy();
        $roundingStrategy = new RoundUpToFiveStrategy();

        return match ($loanTerm) {
            LoanTerm::TwelveMonths => new TwelveMonthsFeeStrategy(
                $this->feeStructureRepository->getFeesForTerm(LoanTerm::TwelveMonths->value),
                $interpolationStrategy,
                $roundingStrategy
            ),
            LoanTerm::TwentyFourMonths => new TwentyFourMonthsFeeStrategy(
                $this->feeStructureRepository->getFeesForTerm(LoanTerm::TwentyFourMonths->value),
                $interpolationStrategy,
                $roundingStrategy
            ),
        };
    }
}
