<?php

namespace Recurrence;

/**
 * Class DatetimeProvider
 * @package Recurrence
 */
class DatetimeProvider
{
    /**
     * @var Recurrence
     */
    private $recurrence;

    /**
     * @param Recurrence $recurrence
     */
    public function __construct(Recurrence $recurrence)
    {
        $this->recurrence = $recurrence;
    }

    /**
     * @return \DatePeriod
     */
    public function provide()
    {
        $interval = $this->recurrence->getFrequency()->getInterval();

        if ($this->recurrence->getInterval() !== 1) {
            $interval = str_replace('1', $this->recurrence->getInterval(), $interval);
        }

        $dateInterval = new \DateInterval($interval);

        return new \DatePeriod(
            $this->recurrence->getPeriodStartAt(),
            $dateInterval,
            $this->recurrence->getPeriodEndAt()
        );
    }
}
