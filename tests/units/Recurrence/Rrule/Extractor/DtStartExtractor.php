<?php

namespace Recurrence\tests\units\Rrule\Extractor;

use Recurrence\Model\Exception\InvalidRruleException;

class DtStartExtractor extends \atoum
{
    /**
     * Failed : Use an invalid DTSTART value.
     */
    public function testInvalidValue(): void
    {
        $this->assert
            ->exception(static function () {
                (new \Recurrence\Rrule\Extractor\DtStartExtractor())->extract('FREQ=MONTHLY;DTSTART=20ERROR12;COUNT=1');
            })
            ->isInstanceOf(InvalidRruleException::class)
            ->hasMessage('Invalid RRULE [DTSTART] option : [20ERROR12]')
        ;
    }

    /**
     * Success : No DTSTART option.
     */
    public function testNoValue(): void
    {
        $dtStart = (new \Recurrence\Rrule\Extractor\DtStartExtractor())->extract('FREQ=MONTHLY;COUNT=1');

        $this->assert
            ->variable($dtStart)
            ->isNull()
        ;
    }

    /**
     * Success : Use a valid DTSTART value.
     */
    public function testValidValue(): void
    {
        $dtStart = (new \Recurrence\Rrule\Extractor\DtStartExtractor())->extract('FREQ=MONTHLY;DTSTART=20170520;COUNT=1');

        $this->assert
            ->string($dtStart[0])
            ->isEqualTo('20170520')
        ;

        $dtStart = (new \Recurrence\Rrule\Extractor\DtStartExtractor())->extract('FREQ=MONTHLY;DTSTART=20181220;COUNT=1');

        $this->assert
            ->string($dtStart[0])
            ->isEqualTo('20181220')
        ;
    }
}
