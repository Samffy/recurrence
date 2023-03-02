<?php

namespace Recurrence\tests\units\Rrule\Extractor;

use atoum;
use Recurrence\Model\Exception\InvalidRruleException;
use Recurrence\Model\Exception\InvalidRruleExpressionException;
use Recurrence\Rrule\RecurrenceProvider;

class IntervalExtractor extends atoum
{
    /**
     * Failed : Use an invalid INTERVAL value
     */
    public function testInvalidValue(): void
    {
        $this->assert
            ->exception(function () {
                (new \Recurrence\Rrule\Extractor\IntervalExtractor())->extract('FREQ=MONTHLY;DTSTART=20170520;INTERVAL=WRONG');
            })
            ->isInstanceOf(InvalidRruleException::class)
            ->hasMessage('Invalid RRULE [INTERVAL] option : [WRONG]')
        ;
    }

    /**
     * Success : No INTERVAL option
     */
    public function testNoValue(): void
    {
        $interval = (new \Recurrence\Rrule\Extractor\IntervalExtractor())->extract('FREQ=MONTHLY;DTSTART=20170520');

        $this->assert
            ->variable($interval)
            ->isNull()
        ;
    }

    /**
     * Success : Use a valid INTERVAL value
     */
    public function testValidValue(): void
    {
        $interval = (new \Recurrence\Rrule\Extractor\IntervalExtractor())->extract('FREQ=MONTHLY;DTSTART=20170520;INTERVAL=1');

        $this->assert
            ->string($interval[0])
            ->isEqualTo('1')
        ;

        $interval = (new \Recurrence\Rrule\Extractor\IntervalExtractor())->extract('FREQ=MONTHLY;DTSTART=20170520;INTERVAL=21');

        $this->assert
            ->string($interval[0])
            ->isEqualTo('21')
        ;
    }

    /**
     * Failed : Missing value for RRULE option
     */
    public function testMissingRruleValue(): void
    {
        // Missing INTERVAL value in RRULE
        $this->assert
            ->exception(function () {
                (new RecurrenceProvider())->create('FREQ=MONTHLY;BYMONTHDAY=1;INTERVAL');
            })
            ->isInstanceOf(InvalidRruleExpressionException::class)
        ;
    }
}
