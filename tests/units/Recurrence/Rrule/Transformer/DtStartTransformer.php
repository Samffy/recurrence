<?php

namespace Recurrence\tests\units\Rrule\Transformer;

use atoum;
use Recurrence\Model\Exception\InvalidRruleException;

/**
 * Class DtStartTransformer
 * @package Recurrence\tests\units\Rrule\Transformer
 */
class DtStartTransformer extends atoum
{
    /**
     * Failed : Use an invalid DTSTART value
     */
    public function testInvalidValue()
    {
        $this->assert
            ->exception(function () {
                (new \Recurrence\Rrule\Transformer\DtStartTransformer())->transform(['A']);
            })
            ->isInstanceOf(InvalidRruleException::class)
            ->hasMessage('Invalid RRULE [DTSTART] option : [A]')
        ;
    }

    /**
     * Success : No DTSTART option
     */
    public function testNoValue()
    {
        $this->assert
            ->exception(function () {
                (new \Recurrence\Rrule\Transformer\DtStartTransformer())->transform([]);
            })
            ->isInstanceOf(InvalidRruleException::class)
            ->hasMessage('Invalid RRULE [DTSTART] option : []')
        ;
    }

    /**
     * Success : Use a valid DTSTART value
     */
    public function testValidValue()
    {
        $dtStart = (new \Recurrence\Rrule\Transformer\DtStartTransformer())->transform(['20170924T193402Z', '20170924T193402Z']);

        $this->assert
            ->object($dtStart)
            ->isEqualTo(\DateTime::createFromFormat('Ymd\THis\Z', '20170924T193402Z', new \DateTimeZone('UTC')))
        ;

        $dtStart = (new \Recurrence\Rrule\Transformer\DtStartTransformer())->transform(['20170924T193402', '20170924T193402']);

        $this->assert
            ->object($dtStart)
            ->isEqualTo(\DateTime::createFromFormat('YmdHis', '20170924193402'))
        ;
    }
}
