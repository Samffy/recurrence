<?php

class Benchmark
{
    /**
     * @param \Datetime $start
     * @param \Datetime $end
     * @return float
     */
    public function launchRecurrGeneration(\Datetime $start, \Datetime $end)
    {
        $startAt = microtime(true);

        $rule = (new \Recurr\Rule)
            ->setStartDate($start)
            ->setUntil($end)
            ->setFreq('MONTHLY')
        ;
        $transformer = new \Recurr\Transformer\ArrayTransformer();
        $recurrences = $transformer->transform($rule);

        foreach ($recurrences as $recurrence) {
            $recurrence->getStart()->format('c');
        }

        return microtime(true) - $startAt;
    }

    /**
     * @param \Datetime $start
     * @param \Datetime $end
     * @return float
     */
    public function launchNativePhpGeneration(\Datetime $start, \Datetime $end)
    {
        $startAt = microtime(true);

        $interval = new \DateInterval('P1M');
        $period = new \DatePeriod($start, $interval, $end);

        // Need to process results, without that, PHP native is too damn fast ! Seems results are generated when accessing data
        foreach ($period as $date) {
            $date->format('c');
        }

        return microtime(true) - $startAt;
    }

    /**
     * @param \Datetime $start
     * @param \Datetime $end
     * @return float
     */
    public function launchRecurrenceGeneration(\Datetime $start, \Datetime $end)
    {
        $startAt = microtime(true);

        $recurrence = (new \Recurrence\Recurrence())
            ->setPeriodStartAt($start)
            ->setPeriodEndAt($end)
            ->setFrequency(new \Recurrence\Frequency(\Recurrence\Frequency::FREQUENCY_MONTHLY))
        ;
        $period = (new \Recurrence\DatetimeProvider($recurrence))->provide();

        foreach ($period as $date) {
            $date->format('c');
        }

        return microtime(true) - $startAt;
    }

}