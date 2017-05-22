<?php

namespace Recurrence\tests\units\RruleTransformer;

require_once __DIR__.'/../../../../src/Recurrence/RruleTransformer/UntilTransformer.php';

use atoum;

/**
 * Class UntilTransformer
 * @package Recurrence\tests\units\RruleTransformer
 */
class UntilTransformer extends atoum
{
    /**
     * Success : Create timezoned Datetime
     */
    public function testTimezonedDatetime()
    {
        // Success creation of recurrence from RRULE using timezoned datetime with TZID option
        $periodStartAt = (new \Recurrence\RruleTransformer\UntilTransformer())->transform('FREQ=MONTHLY;UNTIL;TZID=Europe/Paris:20170520T161322');

        $this->assert
            ->dateTime($periodStartAt)
            ->hasDateAndTime('2017', '05', '20', '16', '13', '22')
            ->dateTime($periodStartAt)
            ->hasTimezone(new \DateTimeZone('Europe/Paris'))
        ;
    }

    /**
     * Success : Create UTC Datetime
     */
    public function testUtcDatetime()
    {
        // Success creation of recurrence from RRULE using datetime with default UTC timezone
        $periodStartAt = (new \Recurrence\RruleTransformer\UntilTransformer())->transform('FREQ=MONTHLY;UNTIL=20170520T161322Z');

        $this->assert
            ->dateTime($periodStartAt)
            ->hasDateAndTime('2017', '05', '20', '16', '13', '22')
            ->dateTime($periodStartAt)
            ->hasTimezone(new \DateTimeZone('UTC'))
        ;
    }

    /**
     * Success : Create Datetime
     */
    public function testDatetime()
    {
        // Success creation of recurrence from RRULE using simple datetime
        $periodStartAt = (new \Recurrence\RruleTransformer\UntilTransformer())->transform('FREQ=MONTHLY;UNTIL=20170520T161322');

        $this->assert
            ->dateTime($periodStartAt)
            ->hasDateAndTime('2017', '05', '20', '16', '13', '22')
            ->dateTime($periodStartAt)
        ;
    }

    /**
     * Success : Create Datetime from simple date format
     */
    public function testDate()
    {
        // Success creation of recurrence from RRULE using simple date format
        $periodStartAt = (new \Recurrence\RruleTransformer\UntilTransformer())->transform('FREQ=MONTHLY;UNTIL=20170520');

        $this->assert
            ->dateTime($periodStartAt)
            ->hasDate('2017', '05', '20')
            ->dateTime($periodStartAt)
        ;
    }

    /**
     * Failed : try different invalid format
     */
    public function testInvalidFormat()
    {
        // Invalid UNTIL
        $this->assert
            ->exception(function () {
                (new \Recurrence\RruleTransformer\UntilTransformer())->transform('FREQ=MONTHLY;UNTIL=201A0520');
            })
            ->isInstanceOf('InvalidArgumentException')
        ;

        // Invalid timezone
        $this->assert
            ->exception(function () {
                (new \Recurrence\RruleTransformer\UntilTransformer())->transform('FREQ=MONTHLY;UNTIL;TZID=Disneyland/Paris:20170520T161322');
            })
            ->isInstanceOf('InvalidArgumentException')
        ;
    }

    /**
     * Success : no UNTIL information in RRULE
     */
    public function testNoUntilFormat()
    {
        // N DoTSTART
        $periodStartAt = (new \Recurrence\RruleTransformer\UntilTransformer())->transform('FREQ=MONTHLY;INTERVAL=2');
        $this->assert
            ->variable($periodStartAt)
            ->isNull();
    }
}