<?php

namespace Benchmark\Recurrence;

class DatetimeProviderBench
{
    /**
     * @Revs(50)
     *
     * @Iterations(3)
     *
     * @OutputTimeUnit("seconds", precision=6)
     */
    public function benchStandardPeriod()
    {
        $recurrence = new \Recurrence\Model\Recurrence(
            new \Recurrence\Model\Frequency('MONTHLY'),
            1,
            new \DateTime('2017-01-01'),
            new \DateTime('2018-01-01'),
        );
        $period = (new \Recurrence\DatetimeProvider())->provide($recurrence);

        foreach ($period as $date) {
            $date->format('c');
        }
    }

    /**
     * @Revs(50)
     *
     * @Iterations(3)
     *
     * @OutputTimeUnit("seconds", precision=6)
     */
    public function benchLongPeriod()
    {
        $recurrence = new \Recurrence\Model\Recurrence(
            new \Recurrence\Model\Frequency('MONTHLY'),
            1,
            new \DateTime('2017-01-01'),
            new \DateTime('2027-01-01'),
        );
        $period = (new \Recurrence\DatetimeProvider())->provide($recurrence);

        foreach ($period as $date) {
            $date->format('c');
        }
    }

    /**
     * @Revs(50)
     *
     * @Iterations(3)
     *
     * @OutputTimeUnit("seconds", precision=6)
     */
    public function benchManyRecurrencesPeriod()
    {
        $recurrence = new \Recurrence\Model\Recurrence(
            new \Recurrence\Model\Frequency('DAILY'),
            1,
            new \DateTime('2017-01-01'),
            new \DateTime('2018-01-01'),
        );
        $period = (new \Recurrence\DatetimeProvider())->provide($recurrence);

        foreach ($period as $date) {
            $date->format('c');
        }
    }

    /**
     * @Revs(50)
     *
     * @Iterations(3)
     *
     * @OutputTimeUnit("seconds", precision=6)
     */
    public function benchEndOfMonthProviderPeriod()
    {
        $recurrence = new \Recurrence\Model\Recurrence(
            new \Recurrence\Model\Frequency('MONTHLY'),
            1,
            new \DateTime('2017-01-01'),
            new \DateTime('2018-01-01'),
            null,
            [new \Recurrence\Constraint\ProviderConstraint\EndOfMonthConstraint()],
        );

        $period = (new \Recurrence\DatetimeProvider())->provide($recurrence);

        foreach ($period as $date) {
            $date->format('c');
        }
    }
}
