<?php

namespace Recurrence\tests\units\Rrule\Transformer;

use Recurrence\Model\Exception\InvalidRruleException;

class DtStartTimezonedTransformer extends \atoum
{
    /**
     * Failed : Use an invalid DTSTART;TZID value.
     */
    public function testInvalidValue(): void
    {
        $this->assert
            ->exception(static function () {
                (new \Recurrence\Rrule\Transformer\DtStartTimezonedTransformer())->transform(['A']);
            })
            ->isInstanceOf(InvalidRruleException::class)
            ->hasMessage('Invalid RRULE [DTSTART;TZID] option : []')
        ;

        $this->assert
            ->exception(static function () {
                (new \Recurrence\Rrule\Transformer\DtStartTimezonedTransformer())->transform(['Miami\Vice', 'B']);
            })
            ->isInstanceOf(InvalidRruleException::class)
            ->hasMessage('Invalid RRULE [DTSTART;TZID] option : [Miami\Vice]')
        ;

        $this->assert
            ->exception(static function () {
                (new \Recurrence\Rrule\Transformer\DtStartTimezonedTransformer())->transform(['A', 'B']);
            })
            ->isInstanceOf(InvalidRruleException::class)
            ->hasMessage('Invalid RRULE [DTSTART;TZID] option : [A, B]')
        ;
    }

    /**
     * Success : No DTSTART;TZID option.
     */
    public function testNoValue(): void
    {
        $this->assert
            ->exception(static function () {
                (new \Recurrence\Rrule\Transformer\DtStartTimezonedTransformer())->transform([]);
            })
            ->isInstanceOf(InvalidRruleException::class)
            ->hasMessage('Invalid RRULE [DTSTART;TZID] option : []')
        ;
    }

    /**
     * Success : Use a valid DTSTART;TZID value.
     */
    public function testValidValue(): void
    {
        $dtStart = (new \Recurrence\Rrule\Transformer\DtStartTimezonedTransformer())->transform(['Europe/Paris', '20170924T193402']);

        $this->assert
            ->object($dtStart)
            ->isEqualTo(\DateTime::createFromFormat('Ymd\THis', '20170924T193402', new \DateTimeZone('Europe/Paris')))
        ;
    }
}
