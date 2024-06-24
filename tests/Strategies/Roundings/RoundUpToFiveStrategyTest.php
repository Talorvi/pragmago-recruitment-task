<?php

declare(strict_types=1);

namespace Strategies\Roundings;

use PHPUnit\Framework\TestCase;
use Talorvi\FeeCalculator\Strategies\Roundings\RoundUpToFiveStrategy;

class RoundUpToFiveStrategyTest extends TestCase
{
    private RoundUpToFiveStrategy $strategy;

    protected function setUp(): void
    {
        $this->strategy = new RoundUpToFiveStrategy();
    }

    public function testRoundUpToFive()
    {
        $fee = $this->strategy->round(103.0, 0.0);
        $this->assertEquals(105.0, $fee);

        $fee = $this->strategy->round(104.0, 0.0);
        $this->assertEquals(105.0, $fee);

        $fee = $this->strategy->round(105.0, 0.0);
        $this->assertEquals(105.0, $fee);

        $fee = $this->strategy->round(106.0, 0.0);
        $this->assertEquals(110.0, $fee);

        $fee = $this->strategy->round(108.0, 0.0);
        $this->assertEquals(110.0, $fee);
    }

    public function testRoundWithAmount()
    {
        $fee = $this->strategy->round(103.0, 1000.0);
        $this->assertEquals(105.0, $fee);

        $fee = $this->strategy->round(104.0, 1000.0);
        $this->assertEquals(105.0, $fee);

        $fee = $this->strategy->round(105.0, 1000.0);
        $this->assertEquals(105.0, $fee);

        $fee = $this->strategy->round(106.0, 1000.0);
        $this->assertEquals(110.0, $fee);

        $fee = $this->strategy->round(109.0, 1000.0);
        $this->assertEquals(110.0, $fee);
    }

    public function testRoundEdgeCases()
    {
        $fee = $this->strategy->round(0.0, 0.0);
        $this->assertEquals(0.0, $fee);

        $fee = $this->strategy->round(1.0, 0.0);
        $this->assertEquals(5.0, $fee);

        $fee = $this->strategy->round(4.999999, 0.0);
        $this->assertEquals(5.0, $fee);

        $fee = $this->strategy->round(5.000001, 0.0);
        $this->assertEquals(10.0, $fee);

        $fee = $this->strategy->round(0.0, 1000.0);
        $this->assertEquals(0.0, $fee);
    }
}
