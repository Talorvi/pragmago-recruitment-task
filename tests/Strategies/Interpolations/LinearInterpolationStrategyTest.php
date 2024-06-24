<?php

declare(strict_types=1);

use PHPUnit\Framework\TestCase;
use Talorvi\FeeCalculator\Repositories\ArrayFeeStructureRepository;
use Talorvi\FeeCalculator\Enums\LoanTerm;
use Talorvi\FeeCalculator\Strategies\Interpolations\LinearInterpolationStrategy;

class LinearInterpolationStrategyTest extends TestCase
{
    private LinearInterpolationStrategy $strategy;
    private array $feeStructure;

    protected function setUp(): void
    {
        $this->strategy = new LinearInterpolationStrategy();

        $feeStructureRepository = new ArrayFeeStructureRepository();
        $this->feeStructure = $feeStructureRepository->getFeesForTerm(LoanTerm::TwelveMonths->value);
    }

    public function testInterpolate()
    {
        $interpolatedValue = $this->strategy->interpolate(1500, $this->feeStructure);
        $this->assertEquals(70, $interpolatedValue);
    }

    public function testInterpolateEdgeCases()
    {
        $interpolatedValue = $this->strategy->interpolate(1000, $this->feeStructure);
        $this->assertEquals(50, $interpolatedValue);

        // Special case where the fee structure is non-linear and has a local minimum at 5000 PLN
        // | 4000 PLN    | 115 PLN|
        // | 5000 PLN    | 100 PLN|
        // | 6000 PLN    | 120 PLN|
        $interpolatedValue = $this->strategy->interpolate(4500, $this->feeStructure);
        $this->assertEquals(107.5, $interpolatedValue);

        $interpolatedValue = $this->strategy->interpolate(20000, $this->feeStructure);
        $this->assertEquals(400, $interpolatedValue);
    }
}
