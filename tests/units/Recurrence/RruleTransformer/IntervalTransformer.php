<?php

namespace Recurrence\tests\units\RruleTransformer;

require_once __DIR__.'/../../../../src/Recurrence/RruleTransformer/IntervalTransformer.php';

use atoum;

/**
 * Class IntervalTransformer
 * @package Recurrence\tests\units\RruleTransformer
 */
class IntervalTransformer extends atoum
{
    /**
     * Failed : Use an invalid interval value
     */
    public function testInvalidValue()
    {
        $this->assert
            ->exception(function () {
                (new \Recurrence\RruleTransformer\IntervalTransformer())->transform('FREQ=MONTHLY;DTSTART=20170520;INTERVAL=WRONG');
            })
            ->isInstanceOf(\InvalidArgumentException::class)
        ;
    }

    /**
     * Success : No interval option
     */
    public function testNoValue()
    {
        $interval = (new \Recurrence\RruleTransformer\IntervalTransformer())->transform('FREQ=MONTHLY;DTSTART=20170520');

        $this->assert
            ->variable($interval)
            ->isNull()
        ;
    }

    /**
     * Success : Use a valid interval value
     */
    public function testValidValue()
    {
        $interval = (new \Recurrence\RruleTransformer\IntervalTransformer())->transform('FREQ=MONTHLY;DTSTART=20170520;INTERVAL=1');

        $this->assert
            ->integer($interval)
            ->isEqualTo(1)
        ;

        $interval = (new \Recurrence\RruleTransformer\IntervalTransformer())->transform('FREQ=MONTHLY;DTSTART=20170520;INTERVAL=21');

        $this->assert
            ->integer($interval)
            ->isEqualTo(21)
        ;
    }

    /**
     * Failed : Missing value for RRULE option
     */
    public function tesMissingRruleValue()
    {
        // Missing INTERVAL value in RRULE
        $this->assert
            ->exception(function () {
                (new \Recurrence\RecurrenceProvider())->parse('FREQ=MONTHLY;BYMONTHDAY=1;INTERVAL');
            })
            ->isInstanceOf(\InvalidArgumentException::class)
        ;
    }
}