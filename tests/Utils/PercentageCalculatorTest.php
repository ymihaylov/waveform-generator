<?php
declare(strict_types=1);

namespace App\Tests\Utils;

use App\Utils\PercentageCalculator;
use PHPUnit\Framework\TestCase;

class PercentageCalculatorTest extends TestCase
{
    /**
     * @dataProvider percentageDataProvider
     */
    public function testCalculatePercentageOfTotal(int | float $number1, int | float $number2, float $expectedPercentage): void
    {
        // Calculate the percentage
        $percentage = PercentageCalculator::calculatePercentageOfTotal($number1, $number2);

        // Assert that the calculated percentage is as expected
        $this->assertEquals(round($expectedPercentage, 2), round($percentage, 2));
    }

    /**
     * @return array
     */
    public static function percentageDataProvider(): array
    {
        return [
            'both numbers are zero' => [0, 0, 0],
            'both numbers are equal' => [50, 50, 50],
            'number1 is greater than number2' => [75, 25, 75],
            'number2 is greater than number1' => [30, 70, 30],
            'floating point numbers' => [1.5, 3.5, 30],
            'floating point numbers close to zero' => [0.0001, 0.0001, 50],
            'negative numbers' => [-1, 1, 0], // invalid input, but test for consistency
            'number1 is zero and number2 is non-zero' => [0, 50, 0],
            'number1 is non-zero and number2 is zero' => [50, 0, 100],
        ];
    }

    /**
     * @return void
     */
    public function testConstructorIsPrivate(): void
    {
        $reflection = new \ReflectionClass(PercentageCalculator::class);
        $constructor = $reflection->getConstructor();

        $this->assertTrue($constructor->isPrivate());
    }
}
