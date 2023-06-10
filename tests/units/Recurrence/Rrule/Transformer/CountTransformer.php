<?php

namespace Recurrence\tests\units\Rrule\Transformer;

use Recurrence\Model\Exception\InvalidRruleException;

class CountTransformer extends \atoum
{
    /**
     * Failed : Use an invalid COUNT value.
     */
    public function testInvalidValue(): void
    {
        $this->assert
            ->exception(static function () {
                (new \Recurrence\Rrule\Transformer\CountTransformer())->transform(['A']);
            })
            ->isInstanceOf(InvalidRruleException::class)
            ->hasMessage('Invalid RRULE [COUNT] option : [A]')
        ;
    }

    /**
     * Success : No COUNT option.
     */
    public function testNoValue(): void
    {
        $this->assert
            ->exception(static function () {
                (new \Recurrence\Rrule\Transformer\CountTransformer())->transform([]);
            })
            ->isInstanceOf(InvalidRruleException::class)
            ->hasMessage('Invalid RRULE [COUNT] option : []')
        ;
    }

    /**
     * Success : Use a valid COUNT value.
     */
    public function testValidValue(): void
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
