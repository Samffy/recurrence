<?php

namespace Recurrence\tests\units\Rrule\Transformer;

use atoum;
use Recurrence\Model\Exception\InvalidRruleException;

class UntilTimezonedTransformer extends atoum
{
    /**
     * Failed : Use an invalid UNTIL;TZID value
     */
    public function testInvalidValue(): void
    {
        $this->assert
            ->exception(function () {
                (new \Recurrence\Rrule\Transformer\UntilTimezonedTransformer())->transform(['A']);
            })
            ->isInstanceOf(InvalidRruleException::class)
            ->hasMessage('Invalid RRULE [UNTIL;TZID] option : []')
        ;

        $this->assert
            ->exception(function () {
                (new \Recurrence\Rrule\Transformer\UntilTimezonedTransformer())->transform(['Miami\Vice', 'B']);
            })
            ->isInstanceOf(InvalidRruleException::class)
            ->hasMessage('Invalid RRULE [UNTIL;TZID] option : [Miami\Vice]')
        ;

        $this->assert
            ->exception(function () {
                (new \Recurrence\Rrule\Transformer\UntilTimezonedTransformer())->transform(['A', 'B']);
            })
            ->isInstanceOf(InvalidRruleException::class)
            ->hasMessage('Invalid RRULE [UNTIL;TZID] option : [A, B]')
        ;
    }

    /**
     * Success : No UNTIL;TZID option
     */
    public function testNoValue(): void
    {
        $this->assert
            ->exception(function () {
                (new \Recurrence\Rrule\Transformer\UntilTimezonedTransformer())->transform([]);
            })
            ->isInstanceOf(InvalidRruleException::class)
            ->hasMessage('Invalid RRULE [UNTIL;TZID] option : []')
        ;
    }

    /**
     * Success : Use a valid UNTIL;TZID value
     */
    public function testValidValue(): void
    {
        $dtStart = (new \Recurrence\Rrule\Transformer\UntilTimezonedTransformer())->transform(['Europe/Paris', '20170924T193402']);

        $this->assert
            ->object($dtStart)
            ->isEqualTo(\DateTime::createFromFormat('Ymd\THis', '20170924T193402', new \DateTimeZone('Europe/Paris')))
        ;
    }
}
