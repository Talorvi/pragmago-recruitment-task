<?php

declare(strict_types=1);

namespace Talorvi\FeeCalculator\Contracts;

interface FeeStructureRepository
{
    public function getFeesForTerm(int $term): array;
}
