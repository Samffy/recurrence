<?php

namespace Recurrence\Provider;

use Recurrence\Model\Recurrence;

abstract class AbstractDatetimeProvider
{
    public function estimatePeriodEndAt(Recurrence $recurrence): ?\DateTime
    {
        $periodEndAt = $recurrence->getPeriodEndAt();

        if ($recurrence->hasCount()) {
            $periodEndAt = clone $recurrence->getPeriodStartAt();
            $periodEndAt->modify(str_replace('1', $recurrence->getCount() * $recurrence->getInterval(), $recurrence->getFrequency()->convertToDateTimeFormat()));
        }

        return $periodEndAt;
    }

    /**
     * @return array<\DateTime>
     */
    abstract public function provide(Recurrence $recurrence): array;
}
