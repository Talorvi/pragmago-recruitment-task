<?php

declare(strict_types=1);

namespace Talorvi\FeeCalculator;

require __DIR__ . '/vendor/autoload.php';

use Talorvi\FeeCalculator\Enums\LoanTerm;
use Talorvi\FeeCalculator\Repositories\ArrayFeeStructureRepository;
use Talorvi\FeeCalculator\Services\FeeCalculatorService;
use Talorvi\FeeCalculator\Models\LoanProposal;
use Talorvi\FeeCalculator\Factories\FeeStrategyFactory;

class App
{
    public function run(): void
    {
        global $argv;

        // Check if the required arguments are provided
        if (count($argv) !== 3) {
            echo "Usage: php App.php [amount] [term]\n";
            echo "Example: php App.php 2750 24\n";
            exit(1);
        }

        // Get the amount and term from command line arguments
        $amount = (float)$argv[1];
        $term = (int)$argv[2];

        // Validate the input parameters
        if ($amount < 1000 || $amount > 20000) {
            echo "Error: Amount must be between 1000 and 20000.\n";
            exit(1);
        }

        // Try to get a valid LoanTerm enum case from the provided term
        $term = LoanTerm::tryFrom($term);

        // If no valid enum case is found, it means the term is invalid
        if ($term === null) {
            echo "Error: Term must be either 12 or 24 months.\n";
            exit(1);
        }

        // Initialize the fee calculator components
        $feeStructureRepository = new ArrayFeeStructureRepository();
        $factory = new FeeStrategyFactory($feeStructureRepository);
        $calculator = new FeeCalculatorService($factory);
        $application = new LoanProposal($term->value, $amount);

        try {
            // Calculate the fee
            $fee = $calculator->calculate($application);
            echo "Calculated Fee: " . $fee . " PLN\n";
        } catch (\Exception $exception) {
            echo "Error: " . $exception->getMessage() . "\n";
        }
    }
}

// Run the application
$app = new App();
$app->run();
