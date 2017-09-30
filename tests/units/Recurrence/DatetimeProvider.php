<?php

namespace Recurrence\tests\units;

use atoum;

use Recurrence\Model\Exception\InvalidRecurrenceException;
use Recurrence\Model\Recurrence;
use Recurrence\Model\Frequency;

/**
 * Class RecurrenceProvider
 * @package Recurrence\tests\units
 */
class DatetimeProvider extends atoum
{

    public function testSuccess()
    {
        $recurrence = new Recurrence();
        $recurrence->setFrequency(new Frequency('MONTHLY'));
        $recurrence->setCount(2);

        $periods = (new \Recurrence\DatetimeProvider())->provide($recurrence);

        $this->assert
            ->integer(count($periods))
            ->isEqualTo(2);

        $recurrence = new Recurrence();
        $recurrence->setFrequency(new Frequency('MONTHLY'));
        $recurrence->setCount(2);
        $recurrence->setInterval(2);

        $periods = (new \Recurrence\DatetimeProvider())->provide($recurrence);

        $this->assert
            ->integer(count($periods))
            ->isEqualTo(2);

        $recurrence = new Recurrence();
        $recurrence->setFrequency(new Frequency('MONTHLY'));
        $periodEndAt = clone $recurrence->getPeriodStartAt();
        $periodEndAt->modify('+1 months');
        $recurrence->setPeriodEndAt($periodEndAt);

        $periods = (new \Recurrence\DatetimeProvider())->provide($recurrence);

        $this->assert
            ->integer(count($periods))
            ->isEqualTo(1);
    }

    public function testFailed()
    {
        $this->assert
            ->exception(function () {
                $recurrence = new Recurrence();
                $recurrence->setCount(2);

                (new \Recurrence\DatetimeProvider())->provide($recurrence);
            })
            ->isInstanceOf(InvalidRecurrenceException::class)
            ->hasMessage('Frequency is required')
        ;
    }
}