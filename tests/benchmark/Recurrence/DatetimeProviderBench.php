<?php

namespace Benchmark\Recurrence;

/**
 * Class DatetimeProviderBench
 *
 * @package Benchmark\Recurrence
 */
class DatetimeProviderBench
{
    /**
     * @Revs(50)
     * @Iterations(3)
     * @OutputTimeUnit("seconds", precision=6)
     */
    public function benchStandardPeriod()
    {
        $recurrence = (new \Recurrence\Recurrence())
            ->setPeriodStartAt(new \Datetime('2017-01-01'))
            ->setPeriodEndAt(new \Datetime('2018-01-01'))
            ->setFrequency(new \Recurrence\Frequency('MONTHLY'))
        ;
        $period = (new \Recurrence\DatetimeProvider())->provide($recurrence);

        foreach ($period as $date) {
            $date->format('c');
        }
    }

    /**
     * @Revs(50)
     * @Iterations(3)
     * @OutputTimeUnit("seconds", precision=6)
     */
    public function benchLongPeriod()
    {
        $recurrence = (new \Recurrence\Recurrence())
            ->setPeriodStartAt(new \Datetime('2017-01-01'))
            ->setPeriodEndAt(new \Datetime('2027-01-01'))
            ->setFrequency(new \Recurrence\Frequency('MONTHLY'))
        ;
        $period = (new \Recurrence\DatetimeProvider())->provide($recurrence);

        foreach ($period as $date) {
            $date->format('c');
        }
    }

    /**
     * @Revs(50)
     * @Iterations(3)
     * @OutputTimeUnit("seconds", precision=6)
     */
    public function benchManyRecurrencesPeriod()
    {
        $recurrence = (new \Recurrence\Recurrence())
            ->setPeriodStartAt(new \Datetime('2017-01-01'))
            ->setPeriodEndAt(new \Datetime('2018-01-01'))
            ->setFrequency(new \Recurrence\Frequency('DAILY'))
        ;
        $period = (new \Recurrence\DatetimeProvider())->provide($recurrence);

        foreach ($period as $date) {
            $date->format('c');
        }
    }
}