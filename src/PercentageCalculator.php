<?php

namespace App;

class PercentageCalculator
{
    /**
     * @param int|float $number1
     * @param int|float $number2
     * @return float
     */
    public function calculatePercentageOfTotal(int | float $number1, int | float $number2): float
    {
        $total = $number1 + $number2;

        if ($total === 0) {
            return 0;
        }

        return ($number1 / $total) * 100;
    }
}
