<?php declare(strict_types=1);

namespace Contracts\Math\Normalizer;

interface NormalizerInterface
{
    public function normalize(float $fee, float $amount): float;
}