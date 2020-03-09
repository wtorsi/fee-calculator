<?php declare(strict_types=1);

namespace Contracts;

interface FeeCalculatorInterface
{
    /**
     * @return int The calculated total fee.
     */
    public function calculate(int $term, float $amount): int;
}