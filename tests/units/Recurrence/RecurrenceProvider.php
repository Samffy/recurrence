<?php

namespace Recurrence\tests\units;

require_once __DIR__.'/../../../src/Recurrence/Frequency.php';
require_once __DIR__.'/../../../src/Recurrence/RecurrenceProvider.php';

use atoum;

/**
 * Class RecurrenceProvider
 * @package Recurrence\tests\units
 */
class RecurrenceProvider extends atoum
{

    /**
     * Failed : Empty RRULE
     */
    public function testEmptyRrule()
    {
        // Empty RRULE
        $this->assert
            ->exception(function () {
                (new \Recurrence\RecurrenceProvider())->parse('');
            })
            ->isInstanceOf(\InvalidArgumentException::class)
        ;
    }

    /**
     * Failed : Bad RRULE syntax
     */
    public function tesBadRruleSyntax()
    {
        // Wrong option syntax in RRULE
        $this->assert
            ->exception(function () {
                (new \Recurrence\RecurrenceProvider())->parse('FREQ:MONTHLY;BYMONTHDAY=1;INTERVAL');
            })
            ->isInstanceOf(\InvalidArgumentException::class)
        ;
    }

    /**
     * Failed : Missing value for RRULE option
     */
    public function tesMissingRruleValue()
    {
        // Missing INTERVAL value in RRULE
        $this->assert
            ->exception(function () {
                (new \Recurrence\RecurrenceProvider())->parse('FREQ=MONTHLY;BYMONTHDAY=1;INTERVAL');
            })
            ->isInstanceOf(\InvalidArgumentException::class)
        ;
    }

    /**
     * Check FREQ support
     */
    public function testRruleFreqSupport()
    {
        // Success creation of recurrence from RRULE
        $recurrence = (new \Recurrence\RecurrenceProvider())->parse('FREQ=MONTHLY;BYMONTHDAY=1;INTERVAL=2');

        $this->assert
            ->string((string) $recurrence->getFrequency())
            ->isEqualTo('MONTHLY')
        ;

        // Wrong frequency name in RRULE
        $this->assert
            ->exception(function () {
                (new \Recurrence\RecurrenceProvider())->parse('FREQUENCY=MONTHLY;BYMONTHDAY=1;INTERVAL=2');
            })
            ->isInstanceOf(\InvalidArgumentException::class)
        ;

        // Wrong frequency option in RRULE
        $this->assert
            ->exception(function () {
                (new \Recurrence\RecurrenceProvider())->parse('FREQ=BADLY;BYMONTHDAY=1;INTERVAL=2');
            })
            ->isInstanceOf(\InvalidArgumentException::class)
        ;
    }

    /**
     * Test DTSTART support
     */
    public function testRruleDstartSupport()
    {
        // Success creation of recurrence from RRULE using simple date
        $recurrence = (new \Recurrence\RecurrenceProvider())->parse('FREQ=MONTHLY;DTSTART=20170520');

        $this->assert
            ->string((string) $recurrence->getFrequency())
            ->isEqualTo('MONTHLY')
            ->dateTime($recurrence->getPeriodStartAt())
            ->hasDate('2017', '05', '20')
        ;

        // Success creation of recurrence from RRULE using datetime
        $recurrence = (new \Recurrence\RecurrenceProvider())->parse('FREQ=MONTHLY;DTSTART=20170520T161322');

        $this->assert
            ->string((string) $recurrence->getFrequency())
            ->isEqualTo('MONTHLY')
            ->dateTime($recurrence->getPeriodStartAt())
            ->hasDateAndTime('2017', '05', '20', '16', '13', '22')
        ;

        // Success creation of recurrence from RRULE using timezoned datetime
        $recurrence = (new \Recurrence\RecurrenceProvider())->parse('FREQ=MONTHLY;DTSTART=20170520T161322Z');

        $this->assert
            ->string((string) $recurrence->getFrequency())
            ->isEqualTo('MONTHLY')
            ->dateTime($recurrence->getPeriodStartAt())
            ->hasDateAndTime('2017', '05', '20', '16', '13', '22')
            ->dateTime($recurrence->getPeriodStartAt())
            ->hasTimezone(new \DateTimeZone('UTC'))
        ;

        // Success creation of recurrence from RRULE using timezoned datetime with TZID option
        $recurrence = (new \Recurrence\RecurrenceProvider())->parse('FREQ=MONTHLY;DTSTART;TZID=Europe/Paris:20170520T161322');

        $this->assert
            ->string((string) $recurrence->getFrequency())
            ->isEqualTo('MONTHLY')
            ->dateTime($recurrence->getPeriodStartAt())
            ->hasDateAndTime('2017', '05', '20', '16', '13', '22')
            ->dateTime($recurrence->getPeriodStartAt())
            ->hasTimezone(new \DateTimeZone('Europe/Paris'))
        ;

        // Invalid datetime
        $this->assert
            ->exception(function () {
                (new \Recurrence\RecurrenceProvider())->parse('FREQ=MONTHLY;DTSTART;TZID=Disneyland/Paris:20170520T161322');
            })
            ->isInstanceOf(\InvalidArgumentException::class)
        ;
    }

    /**
     * Test UNTIL support
     */
    public function testRruleUntilSupport()
    {
        // Success creation of recurrence from RRULE using simple date
        $recurrence = (new \Recurrence\RecurrenceProvider())->parse('FREQ=MONTHLY;UNTIL=20170520');

        $this->assert
            ->string((string) $recurrence->getFrequency())
            ->isEqualTo('MONTHLY')
            ->dateTime($recurrence->getPeriodEndAt())
            ->hasDate('2017', '05', '20')
        ;

        // Success creation of recurrence from RRULE using datetime
        $recurrence = (new \Recurrence\RecurrenceProvider())->parse('FREQ=MONTHLY;UNTIL=20170520T161322');

        $this->assert
            ->string((string) $recurrence->getFrequency())
            ->isEqualTo('MONTHLY')
            ->dateTime($recurrence->getPeriodEndAt())
            ->hasDateAndTime('2017', '05', '20', '16', '13', '22')
        ;

        // Success creation of recurrence from RRULE using timezoned datetime
        $recurrence = (new \Recurrence\RecurrenceProvider())->parse('FREQ=MONTHLY;UNTIL=20170520T161322Z');

        $this->assert
            ->string((string) $recurrence->getFrequency())
            ->isEqualTo('MONTHLY')
            ->dateTime($recurrence->getPeriodEndAt())
            ->hasDateAndTime('2017', '05', '20', '16', '13', '22')
            ->dateTime($recurrence->getPeriodEndAt())
            ->hasTimezone(new \DateTimeZone('UTC'))
        ;

        // Success creation of recurrence from RRULE using timezoned datetime with TZID option
        $recurrence = (new \Recurrence\RecurrenceProvider())->parse('FREQ=MONTHLY;UNTIL;TZID=Europe/Paris:20170520T161322');

        $this->assert
            ->string((string) $recurrence->getFrequency())
            ->isEqualTo('MONTHLY')
            ->dateTime($recurrence->getPeriodEndAt())
            ->hasDateAndTime('2017', '05', '20', '16', '13', '22')
            ->dateTime($recurrence->getPeriodEndAt())
            ->hasTimezone(new \DateTimeZone('Europe/Paris'))
        ;

        // Invalid datetime
        $this->assert
            ->exception(function () {
                (new \Recurrence\RecurrenceProvider())->parse('FREQ=MONTHLY;UNTIL;TZID=Disneyland/Paris:20170520T161322');
            })
            ->isInstanceOf(\InvalidArgumentException::class)
        ;
    }


    /**
     * Check INTERVAL support
     */
    public function testRruleIntervalSupport()
    {
        // Success creation of recurrence from RRULE
        $recurrence = (new \Recurrence\RecurrenceProvider())->parse('FREQ=MONTHLY;BYMONTHDAY=1;INTERVAL=2');

        $this->assert
            ->integer($recurrence->getInterval())
            ->isEqualTo(2);
    }
}