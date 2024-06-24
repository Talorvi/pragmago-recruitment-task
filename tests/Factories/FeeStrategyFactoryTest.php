<?php

declare(strict_types=1);

use PHPUnit\Framework\TestCase;
use Talorvi\FeeCalculator\Factories\FeeStrategyFactory;
use Talorvi\FeeCalculator\Repositories\ArrayFeeStructureRepository;
use Talorvi\FeeCalculator\Enums\LoanTerm;
use Talorvi\FeeCalculator\Strategies\Fees\TwelveMonthsFeeStrategy;
use Talorvi\FeeCalculator\Strategies\Fees\TwentyFourMonthsFeeStrategy;

class FeeStrategyFactoryTest extends TestCase
{
    public function testCreateTwelveMonthsStrategy()
    {
        $feeStructureRepository = new ArrayFeeStructureRepository();
        $factory = new FeeStrategyFactory($feeStructureRepository);
        $strategy = $factory->getStrategy(LoanTerm::TwelveMonths->value);
        $this->assertInstanceOf(TwelveMonthsFeeStrategy::class, $strategy);
    }

    public function testCreateTwentyFourMonthsStrategy()
    {
        $feeStructureRepository = new ArrayFeeStructureRepository();
        $factory = new FeeStrategyFactory($feeStructureRepository);
        $strategy = $factory->getStrategy(LoanTerm::TwentyFourMonths->value);
        $this->assertInstanceOf(TwentyFourMonthsFeeStrategy::class, $strategy);
    }

    public function testCreateInvalidStrategy()
    {
        $this->expectException(InvalidArgumentException::class);
        $feeStructureRepository = new ArrayFeeStructureRepository();
        $factory = new FeeStrategyFactory($feeStructureRepository);
        $factory->getStrategy(36); // This assumes 36 is not a valid term and not defined in LoanTerm enum
    }
}
