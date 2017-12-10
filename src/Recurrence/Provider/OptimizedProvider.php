<?php

namespace Recurrence\Provider;

use Recurrence\Model\Recurrence;

/**
 * Class OptimizedProvider
 * @package Recurrence\Provider
 */
class OptimizedProvider extends AbstractDatetimeProvider
{

    /**
     * @param Recurrence $recurrence
     * @return array<\DateTime>
     */
    public function provide(Recurrence $recurrence)
    {
        $interval = $recurrence->getFrequency()->convertToDateIntervalFormat();

        $periodEndAt = ($recurrence->hasPeriodEndAt())? $recurrence->getPeriodEndAt() : $this->estimatePeriodEndAt($recurrence) ;

        // Transform interval in Datetime interval expression
        if ($recurrence->getInterval() !== 1) {
            $interval = str_replace('1', $recurrence->getInterval(), $interval);
        }

        $dateInterval = new \DateInterval($interval);

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
