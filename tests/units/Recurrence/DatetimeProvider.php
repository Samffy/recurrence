<?php

namespace Recurrence\tests\units;

require_once __DIR__ . '/../../../src/Recurrence/DatetimeProvider.php';

use atoum;
use Recurrence\Recurrence;

class DatetimeProvider extends atoum
{

    /**
     * @dataProvider monthlyFrequenciesDataProvider
     *
     * @param \Datetime $periodStartAt
     * @param \Datetime $periodEndAt
     * @param string    $frequency
     * @param array     $expected
     */
    public function testMonthlyFrequency(\Datetime $periodStartAt, \Datetime $periodEndAt, $frequency, array $expected)
    {
        $recurrence = (new Recurrence())
            ->setPeriodStartAt($periodStartAt)
            ->setPeriodEndAt($periodEndAt)
            ->setFrequency(new \Recurrence\Frequency($frequency))
        ;

        $period = (new \Recurrence\DatetimeProvider($recurrence))->provide();

        $key = 0;
        foreach ($period as $date) {
            $this
                ->dateTime($date)
                ->isEqualTo($expected[$key])
            ;

            $key++;
        }
    }

    protected function monthlyFrequenciesDataProvider()
    {
        return [
            [
                new \Datetime('2017-01-01'),
                new \Datetime('2017-12-31'),
                'MONTHLY',
                [
                    new \Datetime('2017-01-01'),
                    new \Datetime('2017-02-01'),
                    new \Datetime('2017-03-01'),
                    new \Datetime('2017-04-01'),
                    new \Datetime('2017-05-01'),
                    new \Datetime('2017-06-01'),
                    new \Datetime('2017-07-01'),
                    new \Datetime('2017-08-01'),
                    new \Datetime('2017-09-01'),
                    new \Datetime('2017-10-01'),
                    new \Datetime('2017-11-01'),
                    new \Datetime('2017-12-01'),
                ]
            ],
            [
                new \Datetime('2017-01-31'),
                new \Datetime('2017-12-31'),
                'MONTHLY',
                [
                    new \Datetime('2017-01-31'),
                    new \Datetime('2017-03-03'),
                    new \Datetime('2017-04-03'),
                    new \Datetime('2017-05-03'),
                    new \Datetime('2017-06-03'),
                    new \Datetime('2017-07-03'),
                    new \Datetime('2017-08-03'),
                    new \Datetime('2017-09-03'),
                    new \Datetime('2017-10-03'),
                    new \Datetime('2017-11-03'),
                    new \Datetime('2017-12-03'),
                ]
            ]
        ];
    }
}