<?php declare(strict_types=1);

namespace Tests\Math\Normalizer;

use Math\Normalizer\DefaultNormalizer;
use Tests\TestCase;

class DefaultNormalizerTest extends TestCase
{
    /**
     * @dataProvider dataProvider
     */
    public function testNormalization(float $fee, float $amount, float $expected): void
    {
        $normalizer = new DefaultNormalizer();
        $actual = $normalizer->normalize($fee, $amount);
        $this->assertEquals($expected, $actual);
    }

    public function dataProvider(): array
    {
        return [
            [1.1, 10, 5],
            [$x = 1.1, $y = 11.234, \round(\ceil(($x + $y) / 5) * 5 - $y, 2)],
            [$x = .1, $y = 11.234, 3.77],
            [$x = 0, $y = 10, 0],
            [$x = 5.001, $y = 10, 10],
            [$x = 5.0001, $y = 10, 10],
            [$x = -6, $y = -5, -5], //ceil round value up
            [$x = 0, $y = 0, 0], //ceil round value up
            [$x = 2.01, $y = 13, 7], //ceil round value up
            [$x = 0.00001, $y = 13, 2], //ceil round value up
        ];
    }
}