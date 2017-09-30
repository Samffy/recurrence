<?php

namespace Recurrence\tests\units\Rrule\Transformer;

use atoum;
use Recurrence\Model\Exception\InvalidRruleException;

/**
 * Class CountTransformer
 * @package Recurrence\tests\units\Rrule\Transformer
 */
class CountTransformer extends atoum
{
    /**
     * Failed : Use an invalid COUNT value
     */
    public function testInvalidValue()
    {
        $this->assert
            ->exception(function () {
                (new \Recurrence\Rrule\Transformer\CountTransformer())->transform(['A']);
            })
            ->isInstanceOf(InvalidRruleException::class)
            ->hasMessage('Invalid RRULE [COUNT] option : [A]')
        ;
    }

    /**
     * Success : No COUNT option
     */
    public function testNoValue()
    {
        $this->assert
            ->exception(function () {
                (new \Recurrence\Rrule\Transformer\CountTransformer())->transform([]);
            })
            ->isInstanceOf(InvalidRruleException::class)
            ->hasMessage('Invalid RRULE [COUNT] option : []')
        ;
    }

    /**
     * Success : Use a valid COUNT value
     */
    public function testValidValue()
    {
        $count = (new \Recurrence\Rrule\Transformer\CountTransformer())->transform([2]);

        $this->assert
            ->integer($count)
            ->isEqualTo(2)
        ;

        $count = (new \Recurrence\Rrule\Transformer\CountTransformer())->transform([428]);

        $this->assert
            ->integer($count)
            ->isEqualTo(428)
        ;
    }
}
