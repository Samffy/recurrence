<?php

namespace Recurrence\tests\units\Rrule\Extractor;

use atoum;
use Recurrence\Model\Exception\InvalidRruleException;
use Recurrence\Rrule\RecurrenceProvider;

/**
 * Class IntervalExtractor
 * @package Recurrence\tests\units\Rrule\Extractor
 */
class IntervalExtractor extends atoum
{
    /**
     * Failed : Use an invalid INTERVAL value
     */
    public function testInvalidValue()
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
    public function testNoValue()
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
    public function testValidValue()
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
    public function tesMissingRruleValue()
    {
        // Missing INTERVAL value in RRULE
        $this->assert
            ->exception(function () {
                (new RecurrenceProvider())->create('FREQ=MONTHLY;BYMONTHDAY=1;INTERVAL');
            })
            ->isInstanceOf(InvalidRruleException::class)
        ;
    }
}
