<?php

namespace Recurrence\tests\units\Constraint\DatetimeConstraint;

use Recurrence\Constraint\DatetimeConstraint\ExcludeDaysOfWeekConstraint as TestedExcludeDaysOfWeekConstraint;
use Recurrence\Model\Frequency;
use Recurrence\Model\Recurrence;

class ExcludeDaysOfWeekConstraint extends \atoum
{
    public function testInvalidOptions(): void
    {
        $this->assert
            ->exception(static function () {
                new TestedExcludeDaysOfWeekConstraint([1, 2, 3, 4, 5, 6, 7, 8]);
            })
            ->isInstanceOf(\InvalidArgumentException::class)
            ->hasMessage('At least one day of the week must be allowed')
        ;

        $this->assert
            ->exception(static function () {
                new TestedExcludeDaysOfWeekConstraint([1, 'ratatouille']);
            })
            ->isInstanceOf(\InvalidArgumentException::class)
            ->hasMessage('Exclude day must be an integer between 1 and 7')
        ;

        $this->assert
            ->exception(static function () {
                new TestedExcludeDaysOfWeekConstraint([1, 12]);
            })
            ->isInstanceOf(\InvalidArgumentException::class)
            ->hasMessage('Exclude day must be an integer between 1 and 7')
        ;
    }

    /**
     * @dataProvider datetimesLessOneDayProvider
     *
     * @param mixed $originalDatetime
     * @param mixed $expectedDatetime
     */
    public function testExcludeOneDayOfWeek($originalDatetime, $expectedDatetime): void
    {
        $constraint = new TestedExcludeDaysOfWeekConstraint([3]);

        $recurrence = new Recurrence(
            new Frequency(Frequency::FREQUENCY_MONTHLY),
            1,
            new \DateTime('2017-01-31'),
            new \DateTime('2018-01-01'),
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
                new \DateTime('2017-01-01'),
                new \DateTime('2017-01-01'),
            ],
            [
                new \DateTime('2017-01-02'),
                new \DateTime('2017-01-02'),
            ],
            [
                new \DateTime('2017-01-03'),
                new \DateTime('2017-01-03'),
            ],
            [
                new \DateTime('2017-01-04'),
                new \DateTime('2017-01-05'),
            ],
            [
                new \DateTime('2017-01-05'),
                new \DateTime('2017-01-05'),
            ],
            [
                new \DateTime('2017-01-06'),
                new \DateTime('2017-01-06'),
            ],
            [
                new \DateTime('2017-01-07'),
                new \DateTime('2017-01-07'),
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
            new \DateTime('2017-01-31'),
            new \DateTime('2018-01-01'),
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
                new \DateTime('2017-01-01'),
                new \DateTime('2017-01-01'),
            ],
            [
                new \DateTime('2017-01-02'),
                new \DateTime('2017-01-02'),
            ],
            [
                new \DateTime('2017-01-03'),
                new \DateTime('2017-01-04'),
            ],
            [
                new \DateTime('2017-01-04'),
                new \DateTime('2017-01-04'),
            ],
            [
                new \DateTime('2017-01-05'),
                new \DateTime('2017-01-05'),
            ],
            [
                new \DateTime('2017-01-06'),
                new \DateTime('2017-01-07'),
            ],
            [
                new \DateTime('2017-01-07'),
                new \DateTime('2017-01-07'),
            ],
        ];
    }
}
