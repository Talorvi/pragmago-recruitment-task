<?php

declare(strict_types=1);

use PHPUnit\Framework\TestCase;
use Talorvi\FeeCalculator\Factories\FeeStrategyFactory;
use Talorvi\FeeCalculator\Models\LoanProposal;
use Talorvi\FeeCalculator\Repositories\ArrayFeeStructureRepository;
use Talorvi\FeeCalculator\Services\FeeCalculatorService;
use Talorvi\FeeCalculator\Strategies\Interpolations\LinearInterpolationStrategy;
use Talorvi\FeeCalculator\Strategies\Roundings\RoundUpToFiveStrategy;
use Talorvi\FeeCalculator\Enums\LoanTerm;

class FeeCalculatorTest extends TestCase
{
    private FeeCalculatorService $calculator;
    private ArrayFeeStructureRepository $repository;

    public function testCalculateFeeFor12MonthsTerm()
    {
        $loanProposal = new LoanProposal(LoanTerm::TwelveMonths->value, 19250);
        $fee = $this->calculator->calculate($loanProposal);
        $this->assertEquals(385.0, $fee);
    }

    public function testCalculateFeeFor24MonthsTerm()
    {
        $loanProposal = new LoanProposal(LoanTerm::TwentyFourMonths->value, 11500);
        $fee = $this->calculator->calculate($loanProposal);
        $this->assertEquals(460.0, $fee);
    }

    public function testCalculateFeeMinimumAmount12Months()
    {
        $loanProposal = new LoanProposal(LoanTerm::TwelveMonths->value, 1000);
        $fee = $this->calculator->calculate($loanProposal);
        $this->assertEquals(50.0, $fee);
    }

    public function testCalculateFeeMaximumAmount12Months()
    {
        $loanProposal = new LoanProposal(LoanTerm::TwelveMonths->value, 20000);
        $fee = $this->calculator->calculate($loanProposal);
        $this->assertEquals(400.0, $fee);
    }

    public function testCalculateFeeMinimumAmount24Months()
    {
        $loanProposal = new LoanProposal(LoanTerm::TwentyFourMonths->value, 1000);
        $fee = $this->calculator->calculate($loanProposal);
        $this->assertEquals(70.0, $fee);
    }

    public function testCalculateFeeMaximumAmount24Months()
    {
        $loanProposal = new LoanProposal(LoanTerm::TwentyFourMonths->value, 20000);
        $fee = $this->calculator->calculate($loanProposal);
        $this->assertEquals(800.0, $fee);
    }

    public function testCalculateFeeWithInterpolation12Months()
    {
        $loanProposal = new LoanProposal(LoanTerm::TwelveMonths->value, 5500);
        $fee = $this->calculator->calculate($loanProposal);
        // 5500 falls between 5000 and 6000 with fees 100 and 120 respectively
        $this->assertEquals(110.0, $fee);
    }

    public function testCalculateFeeWithInterpolation24Months()
    {
        $loanProposal = new LoanProposal(LoanTerm::TwentyFourMonths->value, 7500);
        $fee = $this->calculator->calculate($loanProposal);
        // 7500 falls between 7000 and 8000 with fees 280 and 320 respectively
        $this->assertEquals(300.0, $fee);
    }

    public function testCalculateFeeWithRounding12Months()
    {
        $loanProposal = new LoanProposal(LoanTerm::TwelveMonths->value, 10150);
        $feeStructure = $this->repository->getFeesForTerm(LoanTerm::TwelveMonths);

        // Calculate the interpolated fee
        $interpolatedFee = (new LinearInterpolationStrategy())->interpolate(10150, $feeStructure);

        // Round the interpolated fee
        $expectedFee = (new RoundUpToFiveStrategy())->round($interpolatedFee, 10150);

        $fee = $this->calculator->calculate($loanProposal);
        $this->assertEquals($expectedFee, $fee);
    }

    public function testCalculateFeeWithRounding24Months()
    {
        $loanProposal = new LoanProposal(LoanTerm::TwentyFourMonths->value, 10150);
        $feeStructure = $this->repository->getFeesForTerm(LoanTerm::TwentyFourMonths);

        // Calculate the interpolated fee
        $interpolatedFee = (new LinearInterpolationStrategy())->interpolate(10150, $feeStructure);

        // Round the interpolated fee
        $expectedFee = (new RoundUpToFiveStrategy())->round($interpolatedFee, 10150);

        $fee = $this->calculator->calculate($loanProposal);
        $this->assertEquals($expectedFee, $fee);
    }

    public function testCalculateExactBreakpoints12Months()
    {
        $breakpoints = [1000, 5000, 10000, 20000];
        $fees = [50, 100, 200, 400];
        foreach ($breakpoints as $index => $amount) {
            $loanProposal = new LoanProposal(LoanTerm::TwelveMonths->value, $amount);
            $fee = $this->calculator->calculate($loanProposal);
            $this->assertEquals($fees[$index], $fee);
        }
    }

    public function testCalculateExactBreakpoints24Months()
    {
        $breakpoints = [1000, 5000, 10000, 20000];
        $fees = [70, 200, 400, 800];
        foreach ($breakpoints as $index => $amount) {
            $loanProposal = new LoanProposal(LoanTerm::TwentyFourMonths->value, $amount);
            $fee = $this->calculator->calculate($loanProposal);
            $this->assertEquals($fees[$index], $fee);
        }
    }

    public function testInvalidTerm()
    {
        $this->expectException(InvalidArgumentException::class);
        $loanProposal = new LoanProposal(36, 5000); // Assuming 36 is not a valid term and not defined in LoanTerm enum
        $this->calculator->calculate($loanProposal);
    }

    protected function setUp(): void
    {
        $this->repository = new ArrayFeeStructureRepository();
        $factory = new FeeStrategyFactory($this->repository);
        $this->calculator = new FeeCalculatorService($factory);
    }
}
