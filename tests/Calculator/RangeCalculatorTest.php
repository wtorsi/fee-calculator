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
                    100 => 100,
                    1000 => 1000,
                ],
            ],
        ]);

        $actual = $calculator->calculate(self::TEST_PERIOD, $amount);
        $this->assertEquals($expected, $actual);
    }

    public function testExactlyCalculate(): void
    {
        $calculator = new RangeCalculator([
            'ranges' => [
                self::TEST_PERIOD => [
                    2000 => 90,
                    3000 => 90,
                ],
            ],
        ]);

        $actual = $calculator->calculate(self::TEST_PERIOD, 2500);
        $this->assertEquals(90, $actual);
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
            [50, 50],
            [60, 60],
            [61, 64],
            [61.22, \round(125 - 61.22, 2)],
            [61.223, \round(125 - 61.223, 2)],
            [0, 0],
            [501, 1005 - 501],
        ];
    }
}