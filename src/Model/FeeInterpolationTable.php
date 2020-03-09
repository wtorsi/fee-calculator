<?php declare(strict_types=1);

namespace Model;

use Exception\InvalidArgumentException;
use Exception\RangeException;

class FeeInterpolationTable
{
    private int $period;
    private array $table;
    private float $min;
    private float $max;

    public function __construct(int $period, array $values)
    {
        $this->period = $period;
        \ksort($values);

        $keys = \array_keys($values);
        $count = \count($keys);
        if ($count < 2) {
            throw new InvalidArgumentException(\sprintf('Passed values array must contain at least 2 ranges.'));
        }

        $this->min = \min($keys);
        $this->max = \max($keys);
        $prev = null;

        for ($i = 1; $i < $count; ++$i) {
            $prev = $keys[$i - 1];
            $current = $keys[$i];

            $this->table[$current] = new FeeInterpolation($prev, $current, $values[$prev], $values[$current]);
        }
    }

    public function get(float $amount): FeeInterpolation
    {
        if ($amount < $this->min) {
            throw new RangeException(\sprintf('Passed amount value %f must be greater than %f', $amount, $this->min));
        }

        foreach ($this->table as $breakpoint => $range) {
            if ($amount <= $breakpoint) {
                return $range;
            }
        }

        throw new RangeException(\sprintf('Passed amount value %f must be less than %f', $amount, $this->max));
    }
}