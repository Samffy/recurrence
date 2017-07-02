<?php

namespace Recurrence\tests\units\RruleTransformer;

require_once __DIR__.'/../../../../src/Recurrence/RruleTransformer/CountTransformer.php';

use atoum;

/**
 * Class CountTransformer
 * @package Recurrence\tests\units\RruleTransformer
 */
class CountTransformer extends atoum
{
    /**
     * Failed : Use an invalid count value
     */
    public function testInvalidValue()
    {
        $this->assert
            ->exception(function () {
                (new \Recurrence\RruleTransformer\CountTransformer())->transform('FREQ=MONTHLY;DTSTART=20170520;COUNT=WRONG');
            })
            ->isInstanceOf(\InvalidArgumentException::class)
        ;
    }

    /**
     * Success : No count option
     */
    public function testNoValue()
    {
        $count = (new \Recurrence\RruleTransformer\CountTransformer())->transform('FREQ=MONTHLY;DTSTART=20170520');

        $this->assert
            ->variable($count)
            ->isNull()
        ;
    }

    /**
     * Success : Use a valid count value
     */
    public function testValidValue()
    {
        $count = (new \Recurrence\RruleTransformer\CountTransformer())->transform('FREQ=MONTHLY;DTSTART=20170520;COUNT=1');

        $this->assert
            ->integer($count)
            ->isEqualTo(1)
        ;

        $count = (new \Recurrence\RruleTransformer\CountTransformer())->transform('FREQ=MONTHLY;DTSTART=20170520;COUNT=21');

        $this->assert
            ->integer($count)
            ->isEqualTo(21)
        ;
    }

    /**
     * Failed : Missing value for RRULE option
     */
    public function tesMissingRruleValue()
    {
        // Missing COUNT value in RRULE
        $this->assert
            ->exception(function () {
                (new \Recurrence\RecurrenceProvider())->parse('FREQ=MONTHLY;BYMONTHDAY=1;COUNT');
            })
            ->isInstanceOf(\InvalidArgumentException::class)
        ;
    }
}