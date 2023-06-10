<?php

namespace Recurrence\tests\units\Rrule\Extractor;

use Recurrence\Model\Exception\InvalidRruleException;

class DtStartTimezonedExtractor extends \atoum
{
    /**
     * Failed : Use an invalid DTSTART;TZID value.
     */
    public function testInvalidValue(): void
    {
        $this->assert
            ->exception(static function () {
                (new \Recurrence\Rrule\Extractor\DtStartTimezonedExtractor())->extract('FREQ=MONTHLY;DTSTART;TZID=20ERROR12;COUNT=1');
            })
            ->isInstanceOf(InvalidRruleException::class)
            ->hasMessage('Invalid RRULE [DTSTART;TZID] option : [20ERROR12]')
        ;
    }

    /**
     * Success : No DTSTART;TZID option.
     */
    public function testNoValue(): void
    {
        $dtStart = (new \Recurrence\Rrule\Extractor\DtStartTimezonedExtractor())->extract('FREQ=MONTHLY;COUNT=1');

        $this->assert
            ->variable($dtStart)
            ->isNull()
        ;
    }

    /**
     * Success : Use a valid DTSTART;TZID value.
     */
    public function testValidValue(): void
    {
        $dtStart = (new \Recurrence\Rrule\Extractor\DtStartTimezonedExtractor())->extract('FREQ=MONTHLY;DTSTART;TZID=Europe/Paris:20170520T154720;COUNT=1');

        $this->assert
            ->string($dtStart[0])
            ->isEqualTo('Europe/Paris')
            ->string($dtStart[1])
            ->isEqualTo('20170520T154720')
        ;

        $dtStart = (new \Recurrence\Rrule\Extractor\DtStartTimezonedExtractor())->extract('FREQ=MONTHLY;DTSTART;TZID=Europe/London:20170520T154720;COUNT=1');

        $this->assert
            ->string($dtStart[0])
            ->isEqualTo('Europe/London')
            ->string($dtStart[1])
            ->isEqualTo('20170520T154720')
        ;
    }
}
