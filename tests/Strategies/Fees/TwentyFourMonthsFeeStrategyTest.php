<?php

declare(strict_types=1);

use PHPUnit\Framework\TestCase;
use Talorvi\FeeCalculator\Repositories\ArrayFeeStructureRepository;
use Talorvi\FeeCalculator\Enums\LoanTerm;
use Talorvi\FeeCalculator\Strategies\Fees\TwentyFourMonthsFeeStrategy;
use Talorvi\FeeCalculator\Strategies\Interpolations\LinearInterpolationStrategy;
use Talorvi\FeeCalculator\Strategies\Roundings\RoundUpToFiveStrategy;

class TwentyFourMonthsFeeStrategyTest extends TestCase
{
    private TwentyFourMonthsFeeStrategy $strategy;

    protected function setUp(): void
    {
        $feeStructureRepository = new ArrayFeeStructureRepository();
        $interpolationStrategy = new LinearInterpolationStrategy();
        $roundingStrategy = new RoundUpToFiveStrategy();

        $this->strategy = new TwentyFourMonthsFeeStrategy($feeStructureRepository->getFeesForTerm(LoanTerm::TwentyFourMonths->value), $interpolationStrategy, $roundingStrategy);
    }

    public function testCalculateFee()
    {
        $fee = $this->strategy->calculate(5000);
        $this->assertEquals(200.0, $fee);
    }
}
