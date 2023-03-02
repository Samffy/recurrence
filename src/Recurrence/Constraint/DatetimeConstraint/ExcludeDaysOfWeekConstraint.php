<?php

namespace Recurrence\Constraint\DatetimeConstraint;

use Recurrence\Constraint\RecurrenceConstraintInterface;
use Recurrence\Model\Recurrence;

class ExcludeDaysOfWeekConstraint implements DatetimeConstraintInterface, RecurrenceConstraintInterface
{
    private array $excludedDays = [];

    public function __construct(array $excludedDays = [])
    {
        $excludedDays = array_unique($excludedDays);

        sort($excludedDays);

        if (count($excludedDays) >= 7) {
            throw new \InvalidArgumentException('At least one day of the week must be allowed');
        }

        foreach ($excludedDays as $excludedDay) {
            $excludedDay = filter_var($excludedDay, FILTER_VALIDATE_INT);

            if (!$excludedDay || $excludedDay < 1 || $excludedDay > 7) {
                throw new \InvalidArgumentException('Exclude day must be an integer between 1 and 7');
            }

            $this->excludedDays[] = $excludedDay;
        }
    }

    public function apply(Recurrence $recurrence, \Datetime $datetime): \Datetime
    {
        while (in_array((int) $datetime->format('N'), $this->excludedDays)) {
            $datetime->modify('+1 day');
        }

        return $datetime;
    }
}
