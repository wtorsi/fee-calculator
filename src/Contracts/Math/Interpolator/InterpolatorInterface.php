<?php declare(strict_types=1);

namespace Contracts\Math\Interpolator;

interface InterpolatorInterface
{
    public function interpolate(float $value, float ...$args): float;
}