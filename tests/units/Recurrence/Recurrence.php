<?php

namespace Recurrence\tests\units;

require_once __DIR__ . '/../../../src/Recurrence/Frequency.php';
require_once __DIR__ . '/../../../src/Recurrence/RecurrenceProvider.php';

use atoum;

class Recurrence extends atoum
{
    public function testEmptyRrule()
    {
        // Empty RRULE
        $this->assert
            ->exception(function() {
                (new \Recurrence\RecurrenceProvider())->parse('');
            })
            ->isInstanceOf('InvalidArgumentException')
        ;
    }

    public function tesBadRruleSyntax()
    {
        // Wrong option syntax in RRULE
        $this->assert
            ->exception(function() {
                (new \Recurrence\RecurrenceProvider())->parse('FREQ:MONTHLY;BYMONTHDAY=1;INTERVAL=2');
            })
            ->isInstanceOf('InvalidArgumentException')
        ;
    }

    public function tesMissingRruleValue()
    {
        // Missing INTERVAL value in RRULE
        $this->assert
            ->exception(function() {
                (new \Recurrence\RecurrenceProvider())->parse('FREQ=MONTHLY;BYMONTHDAY=1;INTERVAL');
            })
            ->isInstanceOf('InvalidArgumentException')
        ;
    }

    public function testRruleFreqSupport()
    {
        // Success creation of recurrence from RRULE
        $recurrence = (new \Recurrence\RecurrenceProvider())->parse('FREQ=MONTHLY;BYMONTHDAY=1;INTERVAL=2');

        $this->assert
            ->string((string)$recurrence->getFrequency())
            ->isEqualTo('MONTHLY')
        ;

        // Wrong frequency name in RRULE
        $this->assert
            ->exception(function() {
                (new \Recurrence\RecurrenceProvider())->parse('FREQUENCY=MONTHLY;BYMONTHDAY=1;INTERVAL=2');
            })
            ->isInstanceOf('InvalidArgumentException')
        ;

        // Wrong frequency option in RRULE
        $this->assert
            ->exception(function() {
                (new \Recurrence\RecurrenceProvider())->parse('FREQ=BADLY;BYMONTHDAY=1;INTERVAL=2');
            })
            ->isInstanceOf('InvalidArgumentException')
        ;
    }


    public function testRruleDstartSupport()
    {
        // Success creation of recurrence from RRULE using simple date
        $recurrence = (new \Recurrence\RecurrenceProvider())->parse('FREQ=MONTHLY;DTSTART=20170520');

        $this->assert
            ->string((string)$recurrence->getFrequency())
            ->isEqualTo('MONTHLY')
            ->dateTime($recurrence->getPeriodStartAt())
            ->hasDate('2017', '05', '20')
        ;

        // Success creation of recurrence from RRULE using datetime
        $recurrence = (new \Recurrence\RecurrenceProvider())->parse('FREQ=MONTHLY;DTSTART=20170520T161322');

        $this->assert
            ->string((string)$recurrence->getFrequency())
            ->isEqualTo('MONTHLY')
            ->dateTime($recurrence->getPeriodStartAt())
            ->hasDateAndTime('2017', '05', '20', '16', '13', '22')
        ;

        // Success creation of recurrence from RRULE using timezoned datetime
        $recurrence = (new \Recurrence\RecurrenceProvider())->parse('FREQ=MONTHLY;DTSTART=20170520T161322Z');

        $this->assert
            ->string((string)$recurrence->getFrequency())
            ->isEqualTo('MONTHLY')
            ->dateTime($recurrence->getPeriodStartAt())
            ->hasDateAndTime('2017', '05', '20', '16', '13', '22')
            ->dateTime($recurrence->getPeriodStartAt())
            ->hasTimezone(new \DateTimeZone('UTC'))
        ;

        // Success creation of recurrence from RRULE using timezoned datetime with TZID option
        $recurrence = (new \Recurrence\RecurrenceProvider())->parse('FREQ=MONTHLY;DTSTART;TZID=Europe/Paris:20170520T161322');

        $this->assert
            ->string((string)$recurrence->getFrequency())
            ->isEqualTo('MONTHLY')
            ->dateTime($recurrence->getPeriodStartAt())
            ->hasDateAndTime('2017', '05', '20', '16', '13', '22')
            ->dateTime($recurrence->getPeriodStartAt())
            ->hasTimezone(new \DateTimeZone('Europe/Paris'))
        ;

        // Invalid datetime
        $this->assert
            ->exception(function() {
                (new \Recurrence\RecurrenceProvider())->parse('FREQ=MONTHLY;DTSTART;TZID=Disneyland/Paris:20170520T161322');
            })
            ->isInstanceOf('InvalidArgumentException')
        ;
    }
}