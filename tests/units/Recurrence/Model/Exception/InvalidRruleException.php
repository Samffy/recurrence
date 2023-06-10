<?php

namespace Recurrence\tests\units\Model\Exception;

class InvalidRruleException extends \atoum
{
    public function testContructor(): void
    {
        $exception = (new \Recurrence\Model\Exception\InvalidRruleException('BIRD', 'IS_THE_WORD'));

        $this->assert
            ->string($exception->getMessage())
            ->isEqualTo('Invalid RRULE [BIRD] option : [IS_THE_WORD]')
        ;
    }
}
