<?php

namespace Recurrence;

/**
 * Class DatetimeProvider
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
        $interval     = $this->recurrence->getFrequency()->getInterval();
        $dateInterval = new \DateInterval($interval);

        return new \DatePeriod(
            $this->recurrence->getPeriodStartAt(),
            $dateInterval,
            $this->recurrence->getPeriodEndAt()
        );
    }
}
