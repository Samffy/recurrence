<?php

namespace Recurrence\tests\units\Rrule\Transformer;

use Recurrence\Model\Exception\InvalidRruleException;
use Recurrence\Model\Frequency;

class FreqTransformer extends \atoum
{
    /**
     * Failed : Use an invalid FREQ value.
     */
    public function testInvalidValue(): void
    {
        $this->assert
            ->exception(static function () {
                (new \Recurrence\Rrule\Transformer\FreqTransformer())->transform(['A']);
            })
            ->isInstanceOf(InvalidRruleException::class)
            ->hasMessage('Invalid RRULE [FREQ] option : [A]')
        ;
    }

    /**
     * Success : No FREQ option.
     */
    public function testNoValue(): void
    {
        $this->assert
            ->exception(static function () {
                (new \Recurrence\Rrule\Transformer\FreqTransformer())->transform([]);
            })
            ->isInstanceOf(InvalidRruleException::class)
            ->hasMessage('Invalid RRULE [FREQ] option : []')
        ;
    }

    /**
     * Success : Use a valid FREQ value.
     */
    public function testValidValue(): void
    {
        $frequency = (new \Recurrence\Rrule\Transformer\FreqTransformer())->transform(['MONTHLY']);

        $this->assert
            ->object($frequency)
            ->isInstanceOf(Frequency::class)
        ;

        $frequency = (new \Recurrence\Rrule\Transformer\FreqTransformer())->transform(['DAILY']);

        $this->assert
            ->object($frequency)
            ->isInstanceOf(Frequency::class)
        ;
    }
}
