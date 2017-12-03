<?php

namespace Recurrence\tests\units\Constraint\DatetimeConstraint;

use atoum;

use Recurrence\Model\Recurrence;
use Recurrence\Constraint\DatetimeConstraint\ExcludeWeekendConstraint as TestedExcludeWeekendConstraint;

/**
 * Class ExcludeWeekendConstraint
 * @package Recurrence\tests\units\Constraint
 */
class ExcludeWeekendConstraint extends atoum
{

    /**
     * @dataProvider datetimesProvider
     */
    public function testDatetimes($originalDatetime, $expectedDatetime)
    {
        $constraint = new TestedExcludeWeekendConstraint();

        $this->assert
            ->object($constraint->apply(new Recurrence(), $originalDatetime))
            ->isEqualTo($expectedDatetime)
        ;
    }

    public function datetimesProvider()
    {
        return [
            // List of datetimes which are not on saturday or sunday
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
                new \Datetime('2017-01-04'),
            ],
            [
                new \Datetime('2017-01-05'),
                new \Datetime('2017-01-05'),
            ],
            [
                new \Datetime('2017-01-06'),
                new \Datetime('2017-01-06'),
            ],
            // List of datetimes in weekend
            [
                new \Datetime('2017-01-01'),
                new \Datetime('2017-01-02'),
            ],
            [
                new \Datetime('2016-12-31'),
                new \Datetime('2017-01-02'),
            ],
        ];
    }
}
