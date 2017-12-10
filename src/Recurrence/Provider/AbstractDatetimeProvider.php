<?php

namespace Recurrence\Provider;

use Recurrence\Model\Recurrence;

/**
 * Class AbstractDatetimeProvider
 * @package Recurrence\Provider
 */
abstract class AbstractDatetimeProvider
{
    /**
     * @param Recurrence $recurrence
     * @return \Datetime
     */
    public function estimatePeriodEndAt(Recurrence $recurrence)
    {
        $periodEndAt = $recurrence->getPeriodEndAt();

        if ($recurrence->hasCount()) {
            $periodEndAt = clone $recurrence->getPeriodStartAt();
            $periodEndAt->modify(str_replace('1', ($recurrence->getCount()*$recurrence->getInterval()), $recurrence->getFrequency()->convertToDateTimeFormat()));
        }

        return $periodEndAt;
    }

    /**
     * @param Recurrence $recurrence
     * @return array<\DateTime>
     */
    abstract public function provide(Recurrence $recurrence);
}
