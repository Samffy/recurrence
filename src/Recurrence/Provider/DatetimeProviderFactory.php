<?php

namespace Recurrence\Provider;

use Recurrence\Constraint\ProviderConstraint\EndOfMonthConstraint;
use Recurrence\Model\Frequency;
use Recurrence\Model\Recurrence;

class DatetimeProviderFactory
{
    public static function create(Recurrence $recurrence): EndOfMonthProvider | OptimizedProvider
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
