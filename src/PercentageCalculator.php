<?php

namespace App;

class PercentageCalculator
{
    public function calculatePercentageOfTotal(float $number1, float $number2)
    {
        $total = $number1 + $number2;

        if ($total === 0) {
            return 0;
        }

        return ($number1 / $total) * 100;
    }
}