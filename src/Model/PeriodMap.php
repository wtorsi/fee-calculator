<?php declare(strict_types=1);

namespace Model;

use Exception\OutOfBoundsException;

class PeriodMap
{
    private array $map;

    public function __construct(array $ranges)
    {
        foreach ($ranges as $period => $values) {
            $this->map[$period] = new FeeInterpolationTable($period, $values);
        }
    }

    public function get(int $term): FeeInterpolationTable
    {
        if (!isset($this->map[$term])) {
            throw new OutOfBoundsException(\sprintf('Passed term value %d is not correct, possible values are %s',
                $term,
                \implode(',', \array_keys($this->map))
            ));
        }

        return $this->map[$term];
    }

    public function getFeeInterpolation(int $term, float $amount): FeeInterpolation
    {
        return $this->get($term)->get($amount);
    }
}