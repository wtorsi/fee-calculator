<?php

declare(strict_types=1);

namespace Contracts;

interface FeeCalculatorInterface
{
    /**
     * @return int the calculated total fee
     */
    public function calculate(int $term, float $amount): float;
}
