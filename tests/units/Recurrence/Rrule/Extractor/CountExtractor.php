<?php

namespace Recurrence\tests\units\Rrule\Extractor;

use atoum;
use Recurrence\Model\Exception\InvalidRruleException;
use Recurrence\Rrule\RecurrenceProvider;

/**
 * Class CountExtractor
 * @package Recurrence\tests\units\Rrule\Extractor
 */
class CountExtractor extends atoum
{
    /**
     * Failed : Use an invalid COUNT value
     */
    public function testInvalidValue()
    {
        $this->assert
            ->exception(function () {
                (new \Recurrence\Rrule\Extractor\CountExtractor())->extract('FREQ=MONTHLY;DTSTART=20170520;COUNT=WRONG');
            })
            ->isInstanceOf(InvalidRruleException::class)
            ->hasMessage('Invalid RRULE [COUNT] option : [WRONG]')
        ;
    }

    /**
     * Success : No COUNT option
     */
    public function testNoValue()
    {
        $count = (new \Recurrence\Rrule\Extractor\CountExtractor())->extract('FREQ=MONTHLY;DTSTART=20170520');

        $this->assert
            ->variable($count)
            ->isNull()
        ;
    }

    /**
     * Success : Use a valid COUNT value
     */
    public function testValidValue()
    {
        $count = (new \Recurrence\Rrule\Extractor\CountExtractor())->extract('FREQ=MONTHLY;DTSTART=20170520;COUNT=1');

        $this->assert
            ->string($count[0])
            ->isEqualTo('1')
        ;

        $count = (new \Recurrence\Rrule\Extractor\CountExtractor())->extract('FREQ=MONTHLY;DTSTART=20170520;COUNT=21');

        $this->assert
            ->string($count[0])
            ->isEqualTo('21')
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
                (new RecurrenceProvider())->create('FREQ=MONTHLY;BYMONTHDAY=1;COUNT');
            })
            ->isInstanceOf(InvalidRruleException::class)
        ;
    }
}
