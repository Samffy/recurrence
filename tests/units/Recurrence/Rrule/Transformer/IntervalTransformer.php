<?php

namespace Recurrence\tests\units\Rrule\Transformer;

use Recurrence\Model\Exception\InvalidRruleException;

class IntervalTransformer extends \atoum
{
    /**
     * Failed : Use an invalid INTERVAL value.
     */
    public function testInvalidValue(): void
    {
        $this->assert
            ->exception(static function () {
                (new \Recurrence\Rrule\Transformer\IntervalTransformer())->transform(['A']);
            })
            ->isInstanceOf(InvalidRruleException::class)
            ->hasMessage('Invalid RRULE [INTERVAL] option : [A]')
        ;
    }

    /**
     * Success : No INTERVAL option.
     */
    public function testNoValue(): void
    {
        $this->assert
            ->exception(static function () {
                (new \Recurrence\Rrule\Transformer\IntervalTransformer())->transform([]);
            })
            ->isInstanceOf(InvalidRruleException::class)
            ->hasMessage('Invalid RRULE [INTERVAL] option : []')
        ;
    }

    /**
     * Success : Use a valid INTERVAL value.
     */
    public function testValidValue(): void
    {
        $interval = (new \Recurrence\Rrule\Transformer\IntervalTransformer())->transform([2]);

        $this->assert
            ->integer($interval)
            ->isEqualTo(2)
        ;

        $interval = (new \Recurrence\Rrule\Transformer\IntervalTransformer())->transform([428]);

        $this->assert
            ->integer($interval)
            ->isEqualTo(428)
        ;
    }
}
