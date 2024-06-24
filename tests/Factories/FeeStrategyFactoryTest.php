<?php

declare(strict_types=1);

use PHPUnit\Framework\TestCase;
use Talorvi\FeeCalculator\Factories\FeeStrategyFactory;
use Talorvi\FeeCalculator\Repositories\ArrayFeeStructureRepository;
use Talorvi\FeeCalculator\Strategies\Fees\TwelveMonthsFeeStrategy;
use Talorvi\FeeCalculator\Strategies\Fees\TwentyFourMonthsFeeStrategy;

class FeeStrategyFactoryTest extends TestCase
{
    public function testCreateTwelveMonthsStrategy()
    {
        $feeStructureRepository = new ArrayFeeStructureRepository();
        $factory = new FeeStrategyFactory($feeStructureRepository);
        $strategy = $factory->getStrategy(12);
        $this->assertInstanceOf(TwelveMonthsFeeStrategy::class, $strategy);
    }

    public function testCreateTwentyFourMonthsStrategy()
    {
        $feeStructureRepository = new ArrayFeeStructureRepository();
        $factory = new FeeStrategyFactory($feeStructureRepository);
        $strategy = $factory->getStrategy(24);
        $this->assertInstanceOf(TwentyFourMonthsFeeStrategy::class, $strategy);
    }

    public function testCreateInvalidStrategy()
    {
        $this->expectException(InvalidArgumentException::class);
        $feeStructureRepository = new ArrayFeeStructureRepository();
        $factory = new FeeStrategyFactory($feeStructureRepository);
        $strategy = $factory->getStrategy(36);
    }
}
