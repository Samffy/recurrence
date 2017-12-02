<?php

namespace Recurrence\tests\units\Rrule;

use atoum;
use Recurrence\Model\Exception\InvalidRruleException;
use Recurrence\Model\Exception\InvalidRruleExpressionException;

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
                (new \Recurrence\Rrule\RecurrenceProvider())->create('');
            })
            ->isInstanceOf(InvalidRruleExpressionException::class)
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
                (new \Recurrence\Rrule\RecurrenceProvider())->create('FREQ:MONTHLY;UNTIL=20170520;BYMONTHDAY=1;INTERVAL');
            })
            ->isInstanceOf(InvalidRruleException::class)
        ;
    }

    /**
     * Failed : Missing required value for RRULE option
     */
    public function tesMissingRruleValue()
    {
        // Missing INTERVAL value in RRULE
        $this->assert
            ->exception(function () {
                (new \Recurrence\Rrule\RecurrenceProvider())->create('FREQ=MONTHLY;UNTIL=20170520;BYMONTHDAY=1;INTERVAL');
            })
            ->isInstanceOf(InvalidRruleException::class)
        ;
    }

    /**
     * Check FREQ support
     */
    public function testRruleFreqSupport()
    {
        // Success creation of recurrence from RRULE
        $recurrence = (new \Recurrence\Rrule\RecurrenceProvider())->create('FREQ=MONTHLY;UNTIL=20170520;BYMONTHDAY=1;INTERVAL=2');

        $this->assert
            ->string((string) $recurrence->getFrequency())
            ->isEqualTo('MONTHLY')
        ;

        // Wrong frequency name in RRULE
        $this->assert
            ->exception(function () {
                (new \Recurrence\Rrule\RecurrenceProvider())->create('FREQUENCY=MONTHLY;UNTIL=20170520;BYMONTHDAY=1;INTERVAL=2');
            })
            ->isInstanceOf(InvalidRruleExpressionException::class)
            ->hasMessage('Frequency is required')
        ;

        // Wrong frequency option in RRULE
        $this->assert
            ->exception(function () {
                (new \Recurrence\Rrule\RecurrenceProvider())->create('FREQ=BADLY;UNTIL=20170520;BYMONTHDAY=1;INTERVAL=2');
            })
            ->isInstanceOf(InvalidRruleException::class)
            ->hasMessage('Invalid RRULE [FREQ] option : [BADLY]')
        ;
    }

    /**
     * Test DTSTART support
     */
    public function testRruleDstartSupport()
    {
        // Success creation of recurrence from RRULE using simple date
        $recurrence = (new \Recurrence\Rrule\RecurrenceProvider())->create('FREQ=MONTHLY;DTSTART=20170520;UNTIL=20170520');

        $this->assert
            ->string((string) $recurrence->getFrequency())
            ->isEqualTo('MONTHLY')
            ->dateTime($recurrence->getPeriodStartAt())
            ->hasDate('2017', '05', '20')
        ;

        // Success creation of recurrence from RRULE using datetime
        $recurrence = (new \Recurrence\Rrule\RecurrenceProvider())->create('FREQ=MONTHLY;DTSTART=20170520T161322;UNTIL=20170520');

        $this->assert
            ->string((string) $recurrence->getFrequency())
            ->isEqualTo('MONTHLY')
            ->dateTime($recurrence->getPeriodStartAt())
            ->hasDateAndTime('2017', '05', '20', '16', '13', '22')
        ;

        // Success creation of recurrence from RRULE using timezoned datetime
        $recurrence = (new \Recurrence\Rrule\RecurrenceProvider())->create('FREQ=MONTHLY;DTSTART=20170520T161322Z;UNTIL=20170520');

        $this->assert
            ->string((string) $recurrence->getFrequency())
            ->isEqualTo('MONTHLY')
            ->dateTime($recurrence->getPeriodStartAt())
            ->hasDateAndTime('2017', '05', '20', '16', '13', '22')
            ->dateTime($recurrence->getPeriodStartAt())
            ->hasTimezone(new \DateTimeZone('UTC'))
        ;

        // Success creation of recurrence from RRULE using timezoned datetime with TZID option
        $recurrence = (new \Recurrence\Rrule\RecurrenceProvider())->create('FREQ=MONTHLY;DTSTART;TZID=Europe/Paris:20170520T161322;UNTIL=20170520');

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
                (new \Recurrence\Rrule\RecurrenceProvider())->create('FREQ=MONTHLY;DTSTART;TZID=Disneyland/Paris:20170520T161322;UNTIL=20170520');
            })
            ->isInstanceOf(InvalidRruleException::class)
            ->hasMessage('Invalid RRULE [DTSTART;TZID] option : [Disneyland/Paris]')
        ;
    }

    /**
     * Test UNTIL support
     */
    public function testRruleUntilSupport()
    {
        // Success creation of recurrence from RRULE using simple date
        $recurrence = (new \Recurrence\Rrule\RecurrenceProvider())->create('FREQ=MONTHLY;UNTIL=20170520');

        $this->assert
            ->string((string) $recurrence->getFrequency())
            ->isEqualTo('MONTHLY')
            ->dateTime($recurrence->getPeriodEndAt())
            ->hasDate('2017', '05', '20')
        ;

        // Success creation of recurrence from RRULE using datetime
        $recurrence = (new \Recurrence\Rrule\RecurrenceProvider())->create('FREQ=MONTHLY;UNTIL=20170520T161322');

        $this->assert
            ->string((string) $recurrence->getFrequency())
            ->isEqualTo('MONTHLY')
            ->dateTime($recurrence->getPeriodEndAt())
            ->hasDateAndTime('2017', '05', '20', '16', '13', '22')
        ;

        // Success creation of recurrence from RRULE using timezoned datetime
        $recurrence = (new \Recurrence\Rrule\RecurrenceProvider())->create('FREQ=MONTHLY;UNTIL=20170520T161322Z');

        $this->assert
            ->string((string) $recurrence->getFrequency())
            ->isEqualTo('MONTHLY')
            ->dateTime($recurrence->getPeriodEndAt())
            ->hasDateAndTime('2017', '05', '20', '16', '13', '22')
            ->dateTime($recurrence->getPeriodEndAt())
            ->hasTimezone(new \DateTimeZone('UTC'))
        ;

        // Success creation of recurrence from RRULE using timezoned datetime with TZID option
        $recurrence = (new \Recurrence\Rrule\RecurrenceProvider())->create('FREQ=MONTHLY;UNTIL;TZID=Europe/Paris:20170520T161322');

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
                (new \Recurrence\Rrule\RecurrenceProvider())->create('FREQ=MONTHLY;UNTIL;TZID=Disneyland/Paris:20170520T161322');
            })
            ->isInstanceOf(InvalidRruleException::class)
            ->hasMessage('Invalid RRULE [UNTIL;TZID] option : [Disneyland/Paris]')
        ;
    }

    /**
     * Check INTERVAL support
     */
    public function testRruleIntervalSupport()
    {
        // Success creation of recurrence from RRULE
        $recurrence = (new \Recurrence\Rrule\RecurrenceProvider())->create('FREQ=MONTHLY;UNTIL=20170520;BYMONTHDAY=1;INTERVAL=2');

        $this->assert
            ->integer($recurrence->getInterval())
            ->isEqualTo(2);
    }

    /**
     * Check COUNT support
     */
    public function testRruleCountSupport()
    {
        // Success creation of recurrence from RRULE
        $recurrence = (new \Recurrence\Rrule\RecurrenceProvider())->create('FREQ=MONTHLY;BYMONTHDAY=1;COUNT=2');

        $this->assert
            ->integer($recurrence->getCount())
            ->isEqualTo(2);

        // You can not create Recurrence with both COUNT and UNTIL option
        $this->assert
            ->exception(function () {
                (new \Recurrence\Rrule\RecurrenceProvider())->create('FREQ=MONTHLY;DTSTART=20170120;UNTIL=20170520;COUNT=2');
            })
            ->isInstanceOf(InvalidRruleExpressionException::class)
            ->hasMessage('Recurrence cannot have [COUNT] and [UNTIL] option at the same time')
        ;

        // You have to set Recurrence with at least COUNT or UNTIL option
        $this->assert
            ->exception(function () {
                (new \Recurrence\Rrule\RecurrenceProvider())->create('FREQ=MONTHLY;DTSTART=20170120;');
            })
            ->isInstanceOf(InvalidRruleExpressionException::class)
            ->hasMessage('Recurrence required [COUNT] or [UNTIL] option')
        ;
    }
}