<?php

namespace Recurrence\tests\units;

use atoum;

use Recurrence\Constraint\DatetimeConstraint\ExcludeWeekendConstraint;
use Recurrence\Model\Exception\InvalidRecurrenceException;
use Recurrence\Model\Recurrence;
use Recurrence\Model\Frequency;

class DatetimeProvider extends atoum
{

    public function testSuccess(): void
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

        $recurrence = new Recurrence();
        $recurrence->setFrequency(new Frequency('MONTHLY'));
        $periodEndAt = clone $recurrence->getPeriodStartAt();
        $periodEndAt->modify('+12 months');
        $recurrence->setPeriodEndAt($periodEndAt);
        $recurrence->addConstraint(new ExcludeWeekendConstraint());

        $periods = (new \Recurrence\DatetimeProvider())->provide($recurrence);

        $this->assert
            ->integer(count($periods))
            ->isEqualTo(12);
    }

    public function testFailed(): void
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

    public function testNoDuplicateDays(): void
    {
        $recurrence = new Recurrence();
        $recurrence->setFrequency(new Frequency('DAILY'));
        $recurrence->setPeriodStartAt(new \Datetime('2017-01-01'));
        $recurrence->setPeriodEndAt(new \Datetime('2017-01-15'));
        $recurrence->addConstraint(new ExcludeWeekendConstraint());

        $periods = (new \Recurrence\DatetimeProvider())->provide($recurrence);

        $this->assert
            ->integer(count($periods))
            ->isEqualTo(10);
    }
}
