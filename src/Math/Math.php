<?php declare(strict_types=1);

namespace Math;

use Exception\InvalidArgumentException;

class Math
{
    private const CEIL = 'ceil';
    private const FLOOR = 'floor';

    public static function ceil(float $value, int $precision = 0): float
    {
        return self::round($value, $precision, self::CEIL);
    }

    public static function floor(float $value, int $precision = 0): float
    {
        return self::round($value, $precision, self::FLOOR);
    }

    public static function round(float $value, int $precision = 0, string $type = null): float
    {
        if (null === $type) {
            return \round($value, $precision);
        }

        if (self::CEIL !== $type && self::FLOOR != $type) {
            throw new InvalidArgumentException('The round only supports the "null", "ceil", and "floor" types.');
        }

        return $type($value * \pow(10, $precision)) / \pow(10, $precision);
    }

    public static function mod(float $value, float $factor): float
    {
        return $value - \floor($value / $factor) * $factor;
    }
}