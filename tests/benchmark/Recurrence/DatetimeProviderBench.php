<?php

namespace Benchmark\Recurrence;

/**
 * Class DatetimeProviderBench
 * @package Benchmark\Recurrence
 */
class DatetimeProviderBench
{
    /**
     * @param array $period
     * @ParamProviders({"providePeriod"})
     * @Revs(50)
     * @Iterations(3)
     * @OutputTimeUnit("seconds", precision=6)
     */
    public function benchRecurrGeneration($period)
    {
        $rule = (new \Recurr\Rule())
            ->setStartDate(new \Datetime($period['start']))
            ->setUntil(new \Datetime($period['end']))
            ->setFreq($period['frequency'])
        ;
        $transformer = new \Recurr\Transformer\ArrayTransformer();
        $recurrences = $transformer->transform($rule);

        foreach ($recurrences as $recurrence) {
            $recurrence->getStart()->format('c');
        }
    }

    /**
     * @param array $period
     * @ParamProviders({"providePeriod"})
     * @Revs(50)
     * @Iterations(3)
     * @OutputTimeUnit("seconds", precision=6)
     */
    public function benchRecurrenceGeneration($period)
    {
        $recurrence = (new \Recurrence\Recurrence())
            ->setPeriodStartAt(new \Datetime($period['start']))
            ->setPeriodEndAt(new \Datetime($period['end']))
            ->setFrequency(new \Recurrence\Frequency($period['frequency']))
        ;
        $period = (new \Recurrence\DatetimeProvider($recurrence))->provide();

        foreach ($period as $date) {
            $date->format('c');
        }
    }

    /**
     * @param array $period
     * @ParamProviders({"providePeriod"})
     * @Revs(50)
     * @Iterations(3)
     * @OutputTimeUnit("seconds", precision=6)
     */
    public function benchNativePhpGeneration($period)
    {
        $interval = new \DateInterval($period['interval']);
        $period = new \DatePeriod(new \Datetime($period['start']), $interval, new \Datetime($period['end']));

        // Need to process results, without that, PHP native is too damn fast ! Seems results are generated when accessing data
        foreach ($period as $date) {
            $date->format('c');
        }
    }

    /**
     * @return array
     */
    public function providePeriod()
    {
        return [
            // Standard period
            [
                'start'     => '2017-01-01',
                'end'       => '2018-01-01',
                'interval'  => 'P1M',
                'frequency' => 'MONTHLY'
            ],
            // Standard period with many recurrences
            [
                'start'     => '2017-01-01',
                'end'       => '2018-01-01',
                'interval'  => 'P1D',
                'frequency' => 'DAILY'
            ],
            // Long period
            [
                'start'     => '2017-01-01',
                'end'       => '2027-01-01',
                'interval'  => 'P1M',
                'frequency' => 'MONTHLY'
            ]
        ];
    }
}