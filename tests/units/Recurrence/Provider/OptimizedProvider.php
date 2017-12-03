<?php

namespace Recurrence\tests\units\Provider;

use atoum;

use Recurrence\Model\Frequency;
use Recurrence\Model\Recurrence;
use Recurrence\Provider\OptimizedProvider as TestedOptimizedProvider;

/**
 * Class OptimizedProvider
 * @package Recurrence\tests\units\Provider
 */
class OptimizedProvider extends atoum
{
    /**
     * @dataProvider datetimesWithoutIntervalProvider
     */
    public function testWithoutIntervalProvide($position, $periodStartAt, $countOption, $expected)
    {
        $recurrence = new Recurrence();
        $recurrence
            ->setFrequency(new Frequency('MONTHLY'))
            ->setPeriodStartAt($periodStartAt)
            ->setCount($countOption)
        ;

        $provider  = new TestedOptimizedProvider();
        $datetimes = $provider->provide($recurrence);

        $this->assert
            ->integer(count($datetimes))
            ->isEqualTo($countOption);

        $this->assert
            ->object($datetimes[$position])
            ->isEqualTo($expected);
    }


    /**
     * @dataProvider datetimesWithoutIntervalProvider
     */
    public function testWithoutIntervalAndWithoutCountProvide($position, $periodStartAt, $countOption, $expected)
    {
        $periodEndAt = clone $periodStartAt;
        $periodEndAt->modify(sprintf('+%d months', $countOption));

        $recurrence = new Recurrence();
        $recurrence
            ->setFrequency(new Frequency('MONTHLY'))
            ->setPeriodStartAt($periodStartAt)
            ->setPeriodEndAt($periodEndAt)
        ;

        $provider  = new TestedOptimizedProvider();
        $datetimes = $provider->provide($recurrence);

        $this->assert
            ->integer(count($datetimes))
            ->isEqualTo($countOption);

        $this->assert
            ->object($datetimes[$position])
            ->isEqualTo($expected);
    }

    public function datetimesWithoutIntervalProvider()
    {
        return [
            [
                0,
                new \Datetime('2017-01-01'),
                10,
                new \Datetime('2017-01-01'),
            ],
            [
                1,
                new \Datetime('2017-01-01'),
                10,
                new \Datetime('2017-02-01'),
            ],
            [
                2,
                new \Datetime('2017-01-01'),
                10,
                new \Datetime('2017-03-01'),
            ],
            [
                3,
                new \Datetime('2017-01-01'),
                10,
                new \Datetime('2017-04-01'),
            ],
            [
                4,
                new \Datetime('2017-01-01'),
                10,
                new \Datetime('2017-05-01'),
            ],
            [
                5,
                new \Datetime('2017-01-01'),
                10,
                new \Datetime('2017-06-01'),
            ],
            [
                6,
                new \Datetime('2017-01-01'),
                10,
                new \Datetime('2017-07-01'),
            ],
        ];
    }


    /**
     * @dataProvider datetimesWithIntervalProvider
     */
    public function testWithIntervalProvide($position, $periodStartAt, $countOption, $expected)
    {
        $recurrence = new Recurrence();
        $recurrence
            ->setFrequency(new Frequency('MONTHLY'))
            ->setPeriodStartAt($periodStartAt)
            ->setCount($countOption)
            ->setInterval(2)
        ;

        $provider  = new TestedOptimizedProvider();
        $datetimes = $provider->provide($recurrence);

        $this->assert
            ->integer(count($datetimes))
            ->isEqualTo($countOption);

        $this->assert
            ->object($datetimes[$position])
            ->isEqualTo($expected);
    }

    public function datetimesWithIntervalProvider()
    {
        return [
            [
                0,
                new \Datetime('2017-01-01'),
                4,
                new \Datetime('2017-01-01'),
            ],
            [
                1,
                new \Datetime('2017-01-01'),
                4,
                new \Datetime('2017-03-01'),
            ],
            [
                2,
                new \Datetime('2017-01-01'),
                4,
                new \Datetime('2017-05-01'),
            ],
            [
                3,
                new \Datetime('2017-01-01'),
                4,
                new \Datetime('2017-07-01'),
            ],
        ];
    }
}
