<?php

declare(strict_types=1);

namespace Talorvi\FeeCalculator\Factories;

use Talorvi\FeeCalculator\Contracts\FeeCalculationStrategy;
use Talorvi\FeeCalculator\Contracts\FeeStructureRepository;
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
        $interpolationStrategy = new LinearInterpolationStrategy();
        $roundingStrategy = new RoundUpToFiveStrategy();

        return match ($term) {
            12 => new TwelveMonthsFeeStrategy($this->feeStructureRepository, $interpolationStrategy, $roundingStrategy),
            24 => new TwentyFourMonthsFeeStrategy($this->feeStructureRepository, $interpolationStrategy, $roundingStrategy),
            default => throw new \InvalidArgumentException("Unsupported loan term: $term"),
        };
    }
}
