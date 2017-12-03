<?php

namespace Recurrence\Constraint\DatetimeConstraint;

use Recurrence\Constraint\RecurrenceConstraintInterface;
use Recurrence\Model\Recurrence;

/**
 * Class ExcludeWeekendConstraint
 * @package Recurrence\Constraint
 */
class ExcludeWeekendConstraint implements DatetimeConstraintInterface, RecurrenceConstraintInterface
{

    /**
     * @param Recurrence $recurrence
     * @param \Datetime $datetime
     * @return \Datetime
     */
    public function apply(Recurrence $recurrence, \Datetime $datetime)
    {
        if ($this->isWeekend($datetime)) {
            // Add 1 or 2 days to skip weekend (we didn't use `next monday` pattern of \Datetime::format cause it remove time)
            $days = (7 - (int) $datetime->format('N') + 1);
            $datetime->modify(sprintf('+%d days', $days));
        }

        return $datetime;
    }

    /**
     * @param \Datetime $datetime
     * @return bool
     */
    private function isWeekend($datetime) {
        return ((int) $datetime->format('N') >= 6);
    }
}
