<?php declare(strict_types=1);

namespace Model;

class FeeInterpolation
{
    private float $startAmount;
    private float $endAmount;
    private float $startFee;
    private float $endFee;

    public function __construct(float $startAmount, float $endAmount, float $startFee, float $endFee)
    {
        $this->startAmount = $startAmount;
        $this->endAmount = $endAmount;
        $this->startFee = $startFee;
        $this->endFee = $endFee;
    }

    public function getStartAmount(): float
    {
        return $this->startAmount;
    }

    public function getEndAmount(): float
    {
        return $this->endAmount;
    }

    public function getStartFee(): float
    {
        return $this->startFee;
    }

    public function getEndFee(): float
    {
        return $this->endFee;
    }
}