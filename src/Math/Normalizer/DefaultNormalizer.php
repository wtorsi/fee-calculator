<?php

declare(strict_types=1);

namespace Math\Normalizer;

use Contracts\Math\Normalizer\NormalizerInterface;
use Math\Math;

class DefaultNormalizer implements NormalizerInterface
{
    private int $precision;
    private int $fraction;

    public function __construct(int $fraction = 5, int $precision = 2)
    {
        $this->fraction = $fraction;
        $this->precision = $precision;
    }

    public function normalize(float $fee, float $amount): float
    {
        $fee = Math::ceil($fee, $this->precision);
        $origin = $fee + $amount;

        // usual % mod allows to use small .001 values to pass this condition
        if (0 === Math::mod($origin, $this->fraction)) {
            return Math::round($fee, $this->precision);
        }

        $rounded = Math::ceil(($fee + $amount) / $this->fraction) * $this->fraction;

        return Math::round($fee + ($rounded - $origin), $this->precision);
    }
}
