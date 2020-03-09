<?php declare(strict_types=1);

namespace Math\Normalizer;

use Contracts\Math\Normalizer\NormalizerInterface;

class DefaultNormalizer implements NormalizerInterface
{
    private const PRECISION = 5;

    public function normalize(float $value): float
    {
        return (int) \round($value / self::PRECISION) * self::PRECISION;
    }
}