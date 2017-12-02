<?php

namespace Recurrence\tests\units\Rrule\Transformer;

use atoum;
use Recurrence\Model\Exception\InvalidRruleException;

/**
 * Class UntilTransformer
 * @package Recurrence\tests\units\Rrule\Transformer
 */
class UntilTransformer extends atoum
{
    /**
     * Failed : Use an invalid UNTIL value
     */
    public function testInvalidValue()
    {
        $this->assert
            ->exception(function () {
                (new \Recurrence\Rrule\Transformer\UntilTransformer())->transform(['A']);
            })
            ->isInstanceOf(InvalidRruleException::class)
            ->hasMessage('Invalid RRULE [UNTIL] option : [A]')
        ;
    }

    /**
     * Success : No UNTIL option
     */
    public function testNoValue()
    {
        $this->assert
            ->exception(function () {
                (new \Recurrence\Rrule\Transformer\UntilTransformer())->transform([]);
            })
            ->isInstanceOf(InvalidRruleException::class)
            ->hasMessage('Invalid RRULE [UNTIL] option : []')
        ;
    }

    /**
     * Success : Use a valid UNTIL value
     */
    public function testValidValue()
    {
        $dtStart = (new \Recurrence\Rrule\Transformer\UntilTransformer())->transform(['20170924T193402Z', '20170924T193402Z']);

        $this->assert
            ->object($dtStart)
            ->isEqualTo(\DateTime::createFromFormat('Ymd\THis\Z', '20170924T193402Z', new \DateTimeZone('UTC')))
        ;

        $dtStart = (new \Recurrence\Rrule\Transformer\UntilTransformer())->transform(['20170924T193402', '20170924T193402']);

        $this->assert
            ->object($dtStart)
            ->isEqualTo(\DateTime::createFromFormat('YmdHis', '20170924193402'))
        ;
    }
}
