<?php

namespace Talorvi\FeeCalculator\Enums;

/**
 * Contains definitions for different types of rounding strategies, such as rounding up to the nearest five units.
 */
enum RoundingType: string
{
    case ROUND_UP_TO_FIVE = 'roundUpToFive';
}