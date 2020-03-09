<?php declare(strict_types=1);

namespace Tests\Calculator;

use Calculator\RangeCalculator;
use Exception\OutOfBoundsException;
use Exception\RangeException;
use Symfony\Component\OptionsResolver\Exception\InvalidOptionsException;
use Tests\TestCase;

class RangeCalculatorTest extends TestCase
{
    private const TEST_PERIOD = 1;

    /**
     * @dataProvider dataProvider
     */
    public function testCalculate(float $amount, float $expected): void
    {
        $calculator = new RangeCalculator([
            'ranges' => [
                self::TEST_PERIOD => [
                    0 => 0,
                    100 => 1,
                    1000 => 100,
                ],
            ],
        ]);

        $actual = $calculator->calculate(self::TEST_PERIOD, $amount);
        $this->assertEquals($expected, $actual);
    }

    public function testRangeUpException(): void
    {
        $calculator = new RangeCalculator([
            'ranges' => [
                self::TEST_PERIOD => [
                    0 => 0,
                    100 => 1,
                ],
            ],
        ]);

        $this->expectException(RangeException::class);
        $calculator->calculate(self::TEST_PERIOD, 101);
    }

    public function testRangeDownException(): void
    {
        $calculator = new RangeCalculator([
            'ranges' => [
                self::TEST_PERIOD => [
                    10 => 0,
                    100 => 1,
                ],
            ],
        ]);

        $this->expectException(RangeException::class);
        $calculator->calculate(self::TEST_PERIOD, 5);
    }

    public function testMisconfiguration(): void
    {
        $this->expectException(InvalidOptionsException::class);
        new RangeCalculator([
            'ranges' => [
                self::TEST_PERIOD => [
                    10 => 0,
                ],
            ],
        ]);
    }

    public function testNotValidPeriod(): void
    {
        $calculator = new RangeCalculator([
            'ranges' => [
                self::TEST_PERIOD => [
                    10 => 0,
                    100 => 1,
                ],
            ],
        ]);

        $this->expectException(OutOfBoundsException::class);
        $calculator->calculate(self::TEST_PERIOD + 1, 100);

    }

    public function dataProvider(): array
    {
        return [
            [50, (1 + .5) * 50],
            [60, 95], // 1.6 * 60 = 96
            [61, 100], // 1.61 * 61 = 98.21
            [100, 200],
            [0, 0],
            [501, \call_user_func(function () { // 23100
                $value = 501;
                $fee = (100 - 1) * ($value - 100) / (1000 - 100) + 1;
                $amount = ((1 + $fee) * $value);

                return \round($amount / 5) * 5;
            })],
        ];
    }
}