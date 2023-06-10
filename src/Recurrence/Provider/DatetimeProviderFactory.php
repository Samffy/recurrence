<?php

namespace Recurrence\Provider;

use Recurrence\Constraint\ProviderConstraint\EndOfMonthConstraint;
use Recurrence\Model\Frequency;
use Recurrence\Model\Recurrence;

class DatetimeProviderFactory
{
    public static function create(Recurrence $recurrence): EndOfMonthProvider|OptimizedProvider
    {
        $provider = new OptimizedProvider();

        if (
            $recurrence->hasConstraint(EndOfMonthConstraint::class)
            && Frequency::FREQUENCY_MONTHLY == (string) $recurrence->getFrequency()
            && in_array((int) $recurrence->getPeriodStartAt()->format('d'), [29, 30, 31], true)
        ) {
            $provider = new EndOfMonthProvider();
        }

        return $provider;
    }
}
