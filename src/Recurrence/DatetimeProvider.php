<?php

namespace Recurrence;

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
        $interval = $recurrence->getFrequency()->convertToDateIntervalFormat();

        // Transform interval in Datetime interval expression
        if ($recurrence->getInterval() !== 1) {
            $interval = str_replace('1', $recurrence->getInterval(), $interval);
        }

        $dateInterval = new \DateInterval($interval);

        // Estimate end date in case of count option
        $periodEndAt = $recurrence->getPeriodEndAt();
        if ($recurrence->hasCount()) {
            $periodEndAt   = clone $recurrence->getPeriodStartAt();
            $periodEndAt->modify(str_replace('1', ($recurrence->getCount()*$recurrence->getInterval()), $recurrence->getFrequency()->convertToDateTimeFormat()));
        }

        $recurrences = iterator_to_array(new \DatePeriod(
            $recurrence->getPeriodStartAt(),
            $dateInterval,
            $periodEndAt
        ));

        // When having count option, return only amount of recurrences requested
        if ($recurrence->hasCount()) {
            return array_slice($recurrences, 0, $recurrence->getCount());
        }

        return $recurrences;
    }
}
