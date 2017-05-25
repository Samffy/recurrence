<?php

namespace Recurrence\tests\units\RruleTransformer;

require_once __DIR__.'/../../../../src/Recurrence/RruleTransformer/FreqTransformer.php';

use atoum;

/**
 * Class FreqTransformer
 * @package Recurrence\tests\units\RruleTransformer
 */
class FreqTransformer extends atoum
{
    /**
     * Failed : Missing frequency value
     */
    public function testMissingValue()
    {
        $this->assert
            ->exception(function () {
                (new \Recurrence\RruleTransformer\FreqTransformer())->transform('DTSTART=20170520;INTERVAL=1');
            })
            ->isInstanceOf('InvalidArgumentException')
        ;
    }

    /**
     * Failed : Use an invalid frequency value, but pattern match on first check
     */
    public function testInvalidValue()
    {
        $this->assert
            ->exception(function () {
                (new \Recurrence\RruleTransformer\FreqTransformer())->transform('FREQ=INVALID;DTSTART=20170520;INTERVAL=1');
            })
            ->isInstanceOf('InvalidArgumentException')
        ;
    }

    /**
     * Failed : Use an invalid frequency value, but patter do not match at all
     */
    public function testReallyInvalidValue()
    {
        $this->assert
            ->exception(function () {
                (new \Recurrence\RruleTransformer\FreqTransformer())->transform('FREQ=666;DTSTART=20170520;INTERVAL=1');
            })
            ->isInstanceOf('InvalidArgumentException')
        ;
    }

    /**
     * Success : Use an valid frequency value
     */
    public function testValidValue()
    {
        $frequency = (new \Recurrence\RruleTransformer\FreqTransformer())->transform('FREQ=MONTHLY;DTSTART=20170520;INTERVAL=1');

        $this->assert
            ->string((string) $frequency)
            ->isEqualTo('MONTHLY')
        ;
    }
}