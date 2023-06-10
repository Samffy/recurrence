<?php

namespace Recurrence\Constraint\DatetimeConstraint;

use Recurrence\Constraint\RecurrenceConstraintInterface;
use Recurrence\Model\Recurrence;

class ExcludeWeekendConstraint implements DatetimeConstraintInterface, RecurrenceConstraintInterface
{
    public function apply(Recurrence $recurrence, \DateTime $datetime): \DateTime
    {
        if ($this->isWeekend($datetime)) {
            // Add 1 or 2 days to skip weekend (we didn't use `next monday` pattern of \Datetime::format cause it remove time)
            $days = (7 - (int) $datetime->format('N') + 1);
            $datetime->modify(sprintf('+%d days', $days));
        }

        return $datetime;
    }

    private function isWeekend(\DateTime $datetime): bool
    {
        return (int) $datetime->format('N') >= 6;
    }
}
