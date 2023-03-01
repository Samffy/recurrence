<?php

namespace Recurrence;

use Recurrence\Constraint\DatetimeConstraint\DatetimeConstraintInterface;
use Recurrence\Model\Recurrence;
use Recurrence\Provider\DatetimeProviderFactory;
use Recurrence\Validator\RecurrenceValidator;

/**
 * Class DatetimeProvider
 * @package Recurrence
 */
class DatetimeProvider
{
    /**
     * @param Recurrence $recurrence
     * @return array<\DateTime>
     */
    public function provide(Recurrence $recurrence)
    {
        RecurrenceValidator::validate($recurrence);

        $provider = DatetimeProviderFactory::create($recurrence);

        $datetimes = $provider->provide($recurrence);

        if (!$recurrence->hasDatetimeConstraint()) {
            return $datetimes;
        }

        $filteredDatetimes = [];

        $previousDatetime = null;
        foreach ($datetimes as $key => $datetime) {
            $filteredDatetime = $this->applyConstraints($recurrence, $datetime);

            // Check that datetime do not pass recurrence end period
            if ($recurrence->hasPeriodEndAt() && $datetime > $recurrence->getPeriodEndAt()) {
                break;
            }

            // Avoid duplicate datetime due to constraint updates
            if (empty($filteredDatetimes) || $previousDatetime != $filteredDatetime) {
                $filteredDatetimes[] = $filteredDatetime;
                $previousDatetime    = $filteredDatetime;
            }
        }

        return $filteredDatetimes;
    }

    /**
     * @param Recurrence $recurrence
     * @param \Datetime  $datetime
     * @return \Datetime
     */
    private function applyConstraints($recurrence, $datetime)
    {
        $filteredDatetime = $datetime;

        // Apply each constraint on current datetime
        foreach ($recurrence->getConstraints() as $constraint) {
            if ($constraint instanceof DatetimeConstraintInterface) {
                $filteredDatetime = $constraint->apply($recurrence, $datetime);
            }
        }

        return $filteredDatetime;
    }
}
