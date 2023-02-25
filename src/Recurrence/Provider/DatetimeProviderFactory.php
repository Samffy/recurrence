<?php

namespace Recurrence\Provider;

use Recurrence\Constraint\ProviderConstraint\EndOfMonthConstraint;
use Recurrence\Model\Frequency;
use Recurrence\Model\Recurrence;

/**
 * Class DatetimeProviderFactory
 * @package Recurrence\Provider
 */
class DatetimeProviderFactory
{
    /**
     * @param Recurrence $recurrence
     * @return EndOfMonthProvider|OptimizedProvider
     */
    public static function create(Recurrence $recurrence)
    {
        $provider = new OptimizedProvider();

        if (
            $recurrence->hasConstraint(EndOfMonthConstraint::class) &&
            (string) $recurrence->getFrequency() == Frequency::FREQUENCY_MONTHLY &&
            in_array((int) $recurrence->getPeriodStartAt()->format('d'), [29, 30, 31])
        ) {
            $provider = new EndOfMonthProvider();
        }

        return $provider;
    }
}
