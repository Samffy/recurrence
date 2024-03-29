<?php

namespace Recurrence\Provider;

use Recurrence\Model\Recurrence;

class EndOfMonthProvider extends AbstractDatetimeProvider
{
    /**
     * @return array<\DateTime>
     */
    public function provide(Recurrence $recurrence): array
    {
        $periodEndAt = ($recurrence->hasPeriodEndAt()) ? $recurrence->getPeriodEndAt() : $this->estimatePeriodEndAt($recurrence);

        $recurrences = [];

        $date = clone $recurrence->getPeriodStartAt();

        while ($date < $periodEndAt) {
            $recurrences[] = clone $date;
            $date->modify('last day of next month');
        }

        // When having count option, return only amount of recurrences requested
        if ($recurrence->hasCount()) {
            return array_slice($recurrences, 0, $recurrence->getCount());
        }

        return $recurrences;
    }
}
