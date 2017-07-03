<?php

namespace Recurrence\tests\units;

require_once __DIR__.'/../../../src/Recurrence/DatetimeProvider.php';

use atoum;
use Recurrence\Recurrence;

/**
 * Class DatetimeProvider
 * @package Recurrence\tests\units
 */
class DatetimeProvider extends atoum
{

    /**
     * @dataProvider periodAndFrequenciesDataProvider
     *
     * @param \Datetime $periodStartAt
     * @param \Datetime $periodEndAt
     * @param string    $frequency
     * @param integer   $interval
     * @param array     $expected
     */
    public function testFrequencyWithEndedPeriod(
        \Datetime $periodStartAt,
        \Datetime $periodEndAt,
        $frequency,
        $interval,
        array $expected
    )
    {
        $recurrence = (new Recurrence())
            ->setPeriodStartAt($periodStartAt)
            ->setPeriodEndAt($periodEndAt)
            ->setFrequency(new \Recurrence\Frequency($frequency))
            ->setInterval($interval)
        ;

        $period = (new \Recurrence\DatetimeProvider())->provide($recurrence);

        $key = 0;
        foreach ($period as $date) {
            $this
                ->dateTime($date)
                ->isEqualTo($expected[$key])
            ;

            $key++;
        }
    }

    /**
     * @return array
     */
    protected function periodAndFrequenciesDataProvider()
    {
        return [
            [
                new \Datetime('2017-01-01'),
                new \Datetime('2017-12-31'),
                'MONTHLY',
                1,
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
                1,
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
            ],
            [
                new \Datetime('2017-01-01'),
                new \Datetime('2020-01-01'),
                'YEARLY',
                1,
                [
                    new \Datetime('2017-01-01'),
                    new \Datetime('2018-01-01'),
                    new \Datetime('2019-01-01'),
                    new \Datetime('2020-01-01'),
                ]
            ],
            [
                new \Datetime('2017-01-31'),
                new \Datetime('2017-12-31'),
                'MONTHLY',
                2,
                [
                    new \Datetime('2017-01-31'),
                    new \Datetime('2017-03-31'),
                    new \Datetime('2017-05-31'),
                    new \Datetime('2017-07-31'),
                    new \Datetime('2017-10-01'),
                    new \Datetime('2017-12-01'),
                ]
            ],
            [
                new \Datetime('2017-01-01'),
                new \Datetime('2020-01-01'),
                'YEARLY',
                2,
                [
                    new \Datetime('2017-01-01'),
                    new \Datetime('2019-01-01'),
                ]
            ],
            [
                new \Datetime('2017-01-01'),
                new \Datetime('2017-06-01'),
                'WEEKLY',
                4,
                [
                    new \Datetime('2017-01-01'),
                    new \Datetime('2017-01-29'),
                    new \Datetime('2017-02-26'),
                    new \Datetime('2017-03-26'),
                    new \Datetime('2017-04-23'),
                    new \Datetime('2017-05-21'),
                ]
            ],
            [
                new \Datetime('2017-02-28'),
                new \Datetime('2017-03-15'),
                'DAILY',
                2,
                [
                    new \Datetime('2017-02-28'),
                    new \Datetime('2017-03-02'),
                    new \Datetime('2017-03-04'),
                    new \Datetime('2017-03-06'),
                    new \Datetime('2017-03-08'),
                    new \Datetime('2017-03-10'),
                    new \Datetime('2017-03-12'),
                    new \Datetime('2017-03-14'),
                ]
            ]
        ];
    }

    /**
     * @dataProvider periodAndFrequenciesDataProvider
     *
     * @param \Datetime $periodStartAt
     * @param \Datetime $periodEndAt
     * @param string    $frequency
     * @param integer   $interval
     * @param array     $expected
     */
    public function testFrequencyWithCount(
        \Datetime $periodStartAt,
        \Datetime $periodEndAt,
        $frequency,
        $interval,
        array $expected
    )
    {
        $recurrence = (new Recurrence())
            ->setPeriodStartAt($periodStartAt)
            ->setCount(count($expected))
            ->setFrequency(new \Recurrence\Frequency($frequency))
            ->setInterval($interval)
        ;

        $period = (new \Recurrence\DatetimeProvider())->provide($recurrence);

        $this->assert
            ->integer(count($period))
            ->isEqualTo(count($expected));

        $key = 0;
        foreach ($period as $date) {
            $this
                ->dateTime($date)
                ->isEqualTo($expected[$key])
            ;

            $key++;
        }
    }
}