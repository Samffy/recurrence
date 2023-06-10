<?php

namespace Recurrence\tests\units\Constraint\DatetimeConstraint;

use Recurrence\Constraint\DatetimeConstraint\ExcludeWeekendConstraint as TestedExcludeWeekendConstraint;
use Recurrence\Model\Frequency;
use Recurrence\Model\Recurrence;

class ExcludeWeekendConstraint extends \atoum
{
    /**
     * @dataProvider datetimesProvider
     *
     * @param mixed $originalDatetime
     * @param mixed $expectedDatetime
     */
    public function testDatetimes($originalDatetime, $expectedDatetime): void
    {
        $constraint = new TestedExcludeWeekendConstraint();

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

    public function datetimesProvider(): array
    {
        return [
            // List of datetimes which are not on saturday or sunday
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
                new \DateTime('2017-01-04'),
            ],
            [
                new \DateTime('2017-01-05'),
                new \DateTime('2017-01-05'),
            ],
            [
                new \DateTime('2017-01-06'),
                new \DateTime('2017-01-06'),
            ],
            // List of datetimes in weekend
            [
                new \DateTime('2017-01-01'),
                new \DateTime('2017-01-02'),
            ],
            [
                new \DateTime('2016-12-31'),
                new \DateTime('2017-01-02'),
            ],
        ];
    }
}
