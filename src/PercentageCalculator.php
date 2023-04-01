<?php

namespace App;

class PercentageCalculator
{
    public function calculatePercentageOfTotal(int | float $number1, int | float $number2): float
    {
        $total = $number1 + $number2;

        if ($total === 0) {
            return 0;
        }

        return ($number1 / $total) * 100;
    }
}