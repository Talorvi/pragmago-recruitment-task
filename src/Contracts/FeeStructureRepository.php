<?php

declare(strict_types=1);

namespace Talorvi\FeeCalculator\Contracts;

use Talorvi\FeeCalculator\Enums\LoanTerm;

interface FeeStructureRepository
{
    public function getFeesForTerm(LoanTerm $term): array;
}
