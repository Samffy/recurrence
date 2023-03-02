<?php

namespace Recurrence\tests\units\Rrule\Extractor;

use atoum;
use Recurrence\Model\Exception\InvalidRruleException;

class UntilExtractor extends atoum
{
    /**
     * Failed : Use an invalid UNTIL value
     */
    public function testInvalidValue(): void
    {
        $this->assert
            ->exception(function () {
                (new \Recurrence\Rrule\Extractor\UntilExtractor())->extract('FREQ=MONTHLY;UNTIL=20ERROR12');
            })
            ->isInstanceOf(InvalidRruleException::class)
            ->hasMessage('Invalid RRULE [UNTIL] option : [20ERROR12]')
        ;
    }

    /**
     * Success : No UNTIL option
     */
    public function testNoValue(): void
    {
        $until = (new \Recurrence\Rrule\Extractor\UntilExtractor())->extract('FREQ=MONTHLY;COUNT=1');

        $this->assert
            ->variable($until)
            ->isNull()
        ;
    }

    /**
     * Success : Use a valid UNTIL value
     */
    public function testValidValue(): void
    {
        $until = (new \Recurrence\Rrule\Extractor\UntilExtractor())->extract('FREQ=MONTHLY;UNTIL=20170520');

        $this->assert
            ->string($until[0])
            ->isEqualTo('20170520')
        ;

        $until = (new \Recurrence\Rrule\Extractor\UntilExtractor())->extract('FREQ=MONTHLY;UNTIL=20181220');

        $this->assert
            ->string($until[0])
            ->isEqualTo('20181220')
        ;
    }
}
