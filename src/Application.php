<?php declare(strict_types=1);

use Contracts\FeeCalculatorInterface;

class Application
{
    private FeeCalculatorInterface $calculator;

    public function __construct(FeeCalculatorInterface $calculator)
    {
        $this->calculator = $calculator;
    }

    public function run(int $term, float $amount): float
    {
        return $this->calculator->calculate($term, $amount);
    }
}