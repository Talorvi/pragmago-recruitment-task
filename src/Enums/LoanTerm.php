<?php

declare(strict_types=1);

namespace Talorvi\FeeCalculator\Enums;

/**
 * Contains an enum representing different loan terms that the application supports, such as 12 or 24 months.
 */
enum LoanTerm: int
{
    case TwelveMonths = 12;
    case TwentyFourMonths = 24;
}