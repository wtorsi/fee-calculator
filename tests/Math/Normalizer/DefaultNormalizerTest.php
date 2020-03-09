<?php declare(strict_types=1);

namespace Tests\Math\Normalizer;

use Math\Normalizer\DefaultNormalizer;
use Tests\TestCase;

class DefaultNormalizerTest extends TestCase
{
    /**
     * @dataProvider dataProvider
     */
    public function testNormalization(float $x, float $expected): void
    {
        $normalizer = new DefaultNormalizer();
        $actual = $normalizer->normalize($x);
        $this->assertEquals($expected, $actual);
    }

    public function dataProvider(): array
    {
        return [
            [12, 10],
            [13, 15],
            [5, 5],
            [.5, 0],
            [15.5, 15],
            [-1, 0],
            [-5, -5],
            [-6, -5],
            [0, 0],
        ];
    }
}