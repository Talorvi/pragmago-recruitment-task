<?php

declare(strict_types=1);

namespace Talorvi\FeeCalculator\Enums;

enum LoanTerm: int
{
    case TwelveMonths = 12;
    case TwentyFourMonths = 24;
}