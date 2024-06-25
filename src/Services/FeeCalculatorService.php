<?php

declare(strict_types=1);

namespace Talorvi\FeeCalculator\Services;

use InvalidArgumentException;
use Talorvi\FeeCalculator\Enums\LoanTerm;
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
        $term = LoanTerm::tryFrom($application->term());

        if ($term === null) {
            throw new InvalidArgumentException();
        }

        $strategy = $this->factory->getStrategy($term);
        return $strategy->calculate($application->amount());
    }
}
