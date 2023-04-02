<?php

namespace App\Utils;

class PercentageCalculator
{
    /**
     * @param int|float $number1
     * @param int|float $number2
     * @return float
     */
    public static function calculatePercentageOfTotal(int | float $number1, int | float $number2): float
    {
        $total = $number1 + $number2;

        if ($total === 0) {
            return 0;
        }

        return ($number1 / $total) * 100;
    }

    private function __construct()
    {
        // Prevent instantiation of the class
    }
}
