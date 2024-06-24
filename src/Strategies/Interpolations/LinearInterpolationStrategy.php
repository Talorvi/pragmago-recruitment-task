<?php

declare(strict_types=1);

namespace Talorvi\FeeCalculator\Strategies\Interpolations;

use Talorvi\FeeCalculator\Contracts\InterpolationStrategy;

/**
 * Interpolate the fee value for a given loan amount.
 *
 * This method performs a linear interpolation to determine the fee for a given
 * loan amount based on the provided fee structure.
 */
class LinearInterpolationStrategy implements InterpolationStrategy
{
    public function interpolate(float $amount, array $feeStructure): float
    {
        ksort($feeStructure);
        $keys = array_keys($feeStructure);

        // Iterate through the sorted keys to find the correct interval for interpolation
        for ($i = 0; $i < count($keys) - 1; $i++) {
            // Check if the given amount falls within the current interval.
            if ($amount >= $keys[$i] && $amount <= $keys[$i + 1]) {
                $lowerBound = $keys[$i];
                $upperBound = $keys[$i + 1];
                $lowerFee = $feeStructure[$lowerBound];
                $upperFee = $feeStructure[$upperBound];
                return $lowerFee + (($amount - $lowerBound) / ($upperBound - $lowerBound)) * ($upperFee - $lowerFee);
            }
        }
        // If the amount is greater than the highest key, return the highest fee
        return $feeStructure[$keys[count($keys) - 1]];
    }
}
