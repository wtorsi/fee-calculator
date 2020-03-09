<?php declare(strict_types=1);

namespace Tests\Math\Interpolator;

use Math\Interpolator\LinearInterpolator;
use Tests\TestCase;

class LinearInterpolatorTest extends TestCase
{
    /**
     * @dataProvider dataProvider
     */
    public function testInterpolation(float $x, float $x0, float $y0, float $x1, float $y1, float $expected): void
    {
        $interpolator = new LinearInterpolator();
        $actual = $interpolator->interpolate($x, $x0, $y0, $x1, $y1);
        $this->assertEquals($expected, $actual);
    }

    public function dataProvider(): array
    {
        return [
            [.5, 0, 0, 1, 100, 50],
            [.5, 0, 0, 1, 1, .5],
            [.3, 0, 0, 1, 100, 30],
            [2, 0, 0, 1, 100, 100],
            [-1, 0, 0, 1, 100, 0],
            [.5, 0, 100, 1, 100, 100],
        ];
    }
}