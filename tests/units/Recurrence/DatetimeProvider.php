<?php

namespace Recurrence\tests\units;

use Recurrence\Constraint\DatetimeConstraint\ExcludeWeekendConstraint;
use Recurrence\Model\Frequency;
use Recurrence\Model\Recurrence;

class DatetimeProvider extends \atoum
{
    public function testProvider(): void
    {
        $recurrence = new Recurrence(
            new Frequency('MONTHLY'),
            1,
            new \DateTime(),
            null,
            2,
        );

        $periods = (new \Recurrence\DatetimeProvider())->provide($recurrence);

        $this->assert
            ->integer(count($periods))
            ->isEqualTo(2)
        ;

        $recurrence = new Recurrence(
            new Frequency('MONTHLY'),
            2,
            new \DateTime(),
            null,
            2,
        );

        $periods = (new \Recurrence\DatetimeProvider())->provide($recurrence);

        $this->assert
            ->integer(count($periods))
            ->isEqualTo(2)
        ;

        $periodStartAt = new \DateTime();
        $periodEndAt = clone $recurrence->getPeriodStartAt();
        $periodEndAt->modify('+1 months');
        $recurrence = new Recurrence(
            new Frequency('MONTHLY'),
            1,
            $periodStartAt,
            $periodEndAt,
        );

        $periods = (new \Recurrence\DatetimeProvider())->provide($recurrence);

        $this->assert
            ->integer(count($periods))
            ->isEqualTo(1)
        ;

        $periodStartAt = new \DateTime();
        $periodEndAt = clone $recurrence->getPeriodStartAt();
        $periodEndAt->modify('+12 months');

        $recurrence = new Recurrence(
            new Frequency('MONTHLY'),
            1,
            $periodStartAt,
            $periodEndAt,
            null,
            [new ExcludeWeekendConstraint()],
        );

        $periods = (new \Recurrence\DatetimeProvider())->provide($recurrence);

        $this->assert
            ->integer(count($periods))
            ->isEqualTo(12)
        ;
    }

    public function testNoDuplicateDays(): void
    {
        $recurrence = new Recurrence(
            new Frequency('DAILY'),
            1,
            new \DateTime('2017-01-01'),
            new \DateTime('2017-01-15'),
            null,
            [new ExcludeWeekendConstraint()],
        );

        $periods = (new \Recurrence\DatetimeProvider())->provide($recurrence);

        $this->assert
            ->integer(count($periods))
            ->isEqualTo(10);
    }
}
