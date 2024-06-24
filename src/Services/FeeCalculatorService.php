<?php

declare(strict_types=1);

namespace Talorvi\FeeCalculator\Services;

use Talorvi\FeeCalculator\Factories\FeeStrategyFactory;
use Talorvi\FeeCalculator\Models\LoanProposal;

class FeeCalculatorService
{
    private FeeStrategyFactory $factory;

    public function __construct(FeeStrategyFactory $factory)
    {
        $this->factory = $factory;
    }

    public function calculate(LoanProposal $application): float
    {
        $strategy = $this->factory->getStrategy($application->term());
        return $strategy->calculate($application->amount());
    }
}
