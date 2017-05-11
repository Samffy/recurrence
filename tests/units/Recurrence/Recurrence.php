<?php

namespace Recurrence\tests\units;

require_once __DIR__ . '/../../../src/Recurrence/Frequency.php';

use atoum;

class Recurrence extends atoum
{

    public function testRruleFreqSupport()
    {
        // Success creation of frequency from RRULE
        $recurrence = \Recurrence\Recurrence::createRecurrenceFromRrule('FREQ=MONTHLY;BYMONTHDAY=1;INTERVAL=2');

        $this->assert
            ->string((string)$recurrence->getFrequency())
            ->isEqualTo('MONTHLY')
        ;

        // Wrong frequency name in RRULE
        $this->assert
            ->exception(function() {
                \Recurrence\Recurrence::createRecurrenceFromRrule('FREQUENCY=MONTHLY;BYMONTHDAY=1;INTERVAL=2');
            })
            ->isInstanceOf('InvalidArgumentException')
        ;

        // Wrong frequency option in RRULE
        $this->assert
            ->exception(function() {
                \Recurrence\Recurrence::createRecurrenceFromRrule('FREQ=BADLY;BYMONTHDAY=1;INTERVAL=2');
            })
            ->isInstanceOf('InvalidArgumentException')
        ;

        // Empty RRULE
        $this->assert
            ->exception(function() {
                \Recurrence\Recurrence::createRecurrenceFromRrule('');
            })
            ->isInstanceOf('InvalidArgumentException')
        ;

        // Wrong option syntax in RRULE
        $this->assert
            ->exception(function() {
                \Recurrence\Recurrence::createRecurrenceFromRrule('FREQ:MONTHLY;BYMONTHDAY=1;INTERVAL=2');
            })
            ->isInstanceOf('InvalidArgumentException')
        ;
    }
}