<?php

namespace Recurrence\tests\units\Constraint\DatetimeConstraint;

use atoum;

use Recurrence\Model\Recurrence;
use Recurrence\Constraint\DatetimeConstraint\ExcludeDaysOfWeekConstraint as TestedExcludeDaysOfWeekConstraint;
use Recurrence\Model\Frequency;

class ExcludeDaysOfWeekConstraint extends atoum
{
    public function testInvalidOptions(): void
    {
        $this->assert
            ->exception(function () {
                new TestedExcludeDaysOfWeekConstraint([1, 2, 3, 4, 5, 6, 7, 8]);
            })
            ->isInstanceOf(\InvalidArgumentException::class)
            ->hasMessage('At least one day of the week must be allowed')
        ;

        $this->assert
            ->exception(function () {
                new TestedExcludeDaysOfWeekConstraint([1, 'ratatouille']);
            })
            ->isInstanceOf(\InvalidArgumentException::class)
            ->hasMessage('Exclude day must be an integer between 1 and 7')
        ;

        $this->assert
            ->exception(function () {
                new TestedExcludeDaysOfWeekConstraint([1, 12]);
            })
            ->isInstanceOf(\InvalidArgumentException::class)
            ->hasMessage('Exclude day must be an integer between 1 and 7')
        ;
    }

    /**
     * @dataProvider datetimesLessOneDayProvider
     */
    public function testExcludeOneDayOfWeek($originalDatetime, $expectedDatetime): void
    {
        $constraint = new TestedExcludeDaysOfWeekConstraint([3]);

        $recurrence = new Recurrence(
            new Frequency(Frequency::FREQUENCY_MONTHLY),
            1,
            new \Datetime('2017-01-31'),
            new \Datetime('2018-01-01'),
        );

        $this->assert
            ->object($constraint->apply($recurrence, $originalDatetime))
            ->isEqualTo($expectedDatetime)
        ;
    }

    public function datetimesLessOneDayProvider(): array
    {
        return [
            [
                new \Datetime('2017-01-01'),
                new \Datetime('2017-01-01'),
            ],
            [
                new \Datetime('2017-01-02'),
                new \Datetime('2017-01-02'),
            ],
            [
                new \Datetime('2017-01-03'),
                new \Datetime('2017-01-03'),
            ],
            [
                new \Datetime('2017-01-04'),
                new \Datetime('2017-01-05'),
            ],
            [
                new \Datetime('2017-01-05'),
                new \Datetime('2017-01-05'),
            ],
            [
                new \Datetime('2017-01-06'),
                new \Datetime('2017-01-06'),
            ],
            [
                new \Datetime('2017-01-07'),
                new \Datetime('2017-01-07'),
            ],
        ];
    }

    /**
     * @dataProvider datetimesLessMultipleDaysProvider
     */
    public function testExcludeMultipleDaysOfWeek(\DateTime $originalDatetime, \DateTime $expectedDatetime): void
    {
        $constraint = new TestedExcludeDaysOfWeekConstraint([2, 5]);

        $recurrence = new Recurrence(
            new Frequency(Frequency::FREQUENCY_MONTHLY),
            1,
            new \Datetime('2017-01-31'),
            new \Datetime('2018-01-01'),
        );

        $this->assert
            ->object($constraint->apply($recurrence, $originalDatetime))
            ->isEqualTo($expectedDatetime)
        ;
    }

    public function datetimesLessMultipleDaysProvider(): array
    {
        return [
            [
                new \Datetime('2017-01-01'),
                new \Datetime('2017-01-01'),
            ],
            [
                new \Datetime('2017-01-02'),
                new \Datetime('2017-01-02'),
            ],
            [
                new \Datetime('2017-01-03'),
                new \Datetime('2017-01-04'),
            ],
            [
                new \Datetime('2017-01-04'),
                new \Datetime('2017-01-04'),
            ],
            [
                new \Datetime('2017-01-05'),
                new \Datetime('2017-01-05'),
            ],
            [
                new \Datetime('2017-01-06'),
                new \Datetime('2017-01-07'),
            ],
            [
                new \Datetime('2017-01-07'),
                new \Datetime('2017-01-07'),
            ],
        ];
    }
}