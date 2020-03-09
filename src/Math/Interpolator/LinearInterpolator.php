<?php

declare(strict_types=1);

namespace Math\Interpolator;

use Contracts\Math\Interpolator\InterpolatorInterface;

class LinearInterpolator implements InterpolatorInterface
{
    /**
     * fn(x) = kx + b
     * fn(x0) = y0
     * fn(x1) = y1.
     *
     * @param float $x0
     * @param float $y0
     * @param float $x1
     * @param float $y1
     */
    public function interpolate(float $x, float ...$args): float
    {
        $fn = static function ($x, $x0, $y0, $x1, $y1): float {
            $x = \min($x1, \max($x0, $x));

            $k = ($y1 - $y0) / ($x1 - $x0);
            $b = $y0 - $k * $x0;

            return $k * $x + $b;
        };

        return $fn($x, ...$args);
    }
}
