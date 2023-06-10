<?php

namespace Recurrence\tests\units\Rrule\Extractor;

use Recurrence\Model\Exception\InvalidRruleException;
use Recurrence\Rrule\RecurrenceProvider;

class FreqExtractor extends \atoum
{
    /**
     * Failed : Use an invalid FREQ value.
     */
    public function testInvalidValue(): void
    {
        $this->assert
            ->exception(static function () {
                (new \Recurrence\Rrule\Extractor\FreqExtractor())->extract('FREQ=1337;DTSTART=20170520;COUNT=1');
            })
            ->isInstanceOf(InvalidRruleException::class)
            ->hasMessage('Invalid RRULE [FREQ] option : [1337]')
        ;
    }

    /**
     * Success : No FREQ option.
     */
    public function testNoValue(): void
    {
        $freq = (new \Recurrence\Rrule\Extractor\FreqExtractor())->extract('FREQ=;DTSTART=20170520');

        $this->assert
            ->variable($freq)
            ->isNull()
        ;
    }

    /**
     * Success : Use a valid FREQ value.
     */
    public function testValidValue(): void
    {
        $freq = (new \Recurrence\Rrule\Extractor\FreqExtractor())->extract('FREQ=MONTHLY;DTSTART=20170520;COUNT=1');

        $this->assert
            ->string($freq[0])
            ->isEqualTo('MONTHLY')
        ;

        $freq = (new \Recurrence\Rrule\Extractor\FreqExtractor())->extract('FREQ=DAILY;DTSTART=20170520;COUNT=21');

        $this->assert
            ->string($freq[0])
            ->isEqualTo('DAILY')
        ;
    }

    /**
     * Failed : Missing value for RRULE option.
     */
    public function tesMissingRruleValue(): void
    {
        // Missing COUNT value in RRULE
        $this->assert
            ->exception(static function () {
                (new RecurrenceProvider())->create('BYMONTHDAY=1;COUNT');
            })
            ->isInstanceOf(InvalidRruleException::class)
        ;
    }
}
