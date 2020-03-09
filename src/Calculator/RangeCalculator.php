<?php

declare(strict_types=1);

namespace Calculator;

use Contracts\FeeCalculatorInterface;
use Contracts\Math\Interpolator\InterpolatorInterface;
use Contracts\Math\Normalizer\NormalizerInterface;
use Math\Interpolator\LinearInterpolator;
use Math\Normalizer\DefaultNormalizer;
use Model\FeeInterpolation;
use Model\PeriodMap;
use Symfony\Component\OptionsResolver\Exception\InvalidOptionsException;
use Symfony\Component\OptionsResolver\Options;
use Symfony\Component\OptionsResolver\OptionsResolver;

class RangeCalculator implements FeeCalculatorInterface
{
    private array $options = [];

    public function __construct(array $options = [])
    {
        $resolver = new OptionsResolver();
        $this->configure($resolver);

        $this->options = $resolver->resolve($options);
    }

    public function calculate(int $term, float $amount): float
    {
        /** @var PeriodMap $map */
        $map = $this->options['ranges'];
        $fee = $map->getFeeInterpolation($term, $amount);

        return $this->doCalculate($fee, $amount);
    }

    private function configure(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'interpolator' => fn (Options $options) => new LinearInterpolator(),
            'normalizer' => fn (Options $options) => new DefaultNormalizer(),
            'ranges' => [],
        ]);

        $resolver->setAllowedTypes('interpolator', InterpolatorInterface::class);
        $resolver->setAllowedTypes('normalizer', NormalizerInterface::class);
        $resolver->setAllowedTypes('ranges', ['array', PeriodMap::class]);

        $resolver->setNormalizer('ranges', function (Options $options, array $value): PeriodMap {
            if ($value instanceof PeriodMap) {
                return $value;
            }

            foreach ($value as $key => $values) {
                if (!\is_array($values) || \count($values) < 2) {
                    throw new InvalidOptionsException(\sprintf('Passed ranges for period must contain at least 2 values.'));
                }
            }

            return new PeriodMap($value);
        });
    }

    private function doCalculate(FeeInterpolation $feeInterpolation, float $amount): float
    {
        /** @var InterpolatorInterface $interpolation */
        $interpolation = $this->options['interpolator'];
        $fee = $interpolation->interpolate(
            $amount,
            $feeInterpolation->getStartAmount(),
            $feeInterpolation->getStartFee(),
            $feeInterpolation->getEndAmount(),
            $feeInterpolation->getEndFee()
        );

        /** @var NormalizerInterface $normalizer */
        $normalizer = $this->options['normalizer'];

        return $normalizer->normalize($fee, $amount);
    }
}
