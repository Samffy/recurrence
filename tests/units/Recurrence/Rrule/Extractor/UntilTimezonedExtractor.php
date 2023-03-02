<?php

namespace Recurrence\tests\units\Rrule\Extractor;

use atoum;
use Recurrence\Model\Exception\InvalidRruleException;

class UntilTimezonedExtractor extends atoum
{
    /**
     * Failed : Use an invalid UNTIL;TZID value
     */
    public function testInvalidValue(): void
    {
        $this->assert
            ->exception(function () {
                (new \Recurrence\Rrule\Extractor\UntilTimezonedExtractor())->extract('FREQ=MONTHLY;UNTIL;TZID=20ERROR12;COUNT=1');
            })
            ->isInstanceOf(InvalidRruleException::class)
            ->hasMessage('Invalid RRULE [UNTIL;TZID] option : [20ERROR12]')
        ;
    }

    /**
     * Success : No UNTIL;TZID option
     */
    public function testNoValue(): void
    {
        $until = (new \Recurrence\Rrule\Extractor\UntilTimezonedExtractor())->extract('FREQ=MONTHLY;COUNT=1');

        $this->assert
            ->variable($until)
            ->isNull()
        ;
    }

    /**
     * Success : Use a valid UNTIL;TZID value
     */
    public function testValidValue(): void
    {
        $until = (new \Recurrence\Rrule\Extractor\UntilTimezonedExtractor())->extract('FREQ=MONTHLY;UNTIL;TZID=Europe/Paris:20170520T154720;COUNT=1');

        $this->assert
            ->string($until[0])
            ->isEqualTo('Europe/Paris')
            ->string($until[1])
            ->isEqualTo('20170520T154720')
        ;

        $until = (new \Recurrence\Rrule\Extractor\UntilTimezonedExtractor())->extract('FREQ=MONTHLY;UNTIL;TZID=Europe/London:20170520T154720;COUNT=1');

        $this->assert
            ->string($until[0])
            ->isEqualTo('Europe/London')
            ->string($until[1])
            ->isEqualTo('20170520T154720')
        ;
    }
}
