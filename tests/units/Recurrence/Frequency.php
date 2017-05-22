<?php

namespace Recurrence\tests\units;

require_once __DIR__.'/../../../src/Recurrence/Frequency.php';

use atoum;

/**
 * Class Frequency
 * @package Recurrence\tests\units
 */
class Frequency extends atoum
{

    /**
     * Use an invalid frequency value on construct
     */
    public function testConstructor()
    {
        $this->assert
            ->exception(function () {
                new \Recurrence\Frequency('INVALID_FREQUENCY_NAME');
            })
            ->isInstanceOf('InvalidArgumentException')
        ;
    }

    /**
     * Validate get interval from frequency for each supported frequency
     *
     * @dataProvider frequenciesDataProvider
     *
     * @param string $frequencyName
     * @param string $expectedIntervalName
     */
    public function testGetInterval($frequencyName, $expectedIntervalName)
    {
        $frequency = new \Recurrence\Frequency($frequencyName);

        $this->assert
            ->string($frequency->getInterval())
            ->isEqualTo($expectedIntervalName);
    }

    /**
     * Validate that __toString method return frequency name
     */
    public function testToString()
    {
        $frequency = new \Recurrence\Frequency('MONTHLY');
        $this->assert
            ->string((string) $frequency)
            ->isEqualTo('MONTHLY')
        ;
    }

    /**
     * @return array
     */
    protected function frequenciesDataProvider()
    {
        return [
            ['YEARLY', 'P1Y'],
            ['MONTHLY', 'P1M'],
            ['WEEKLY', 'P1W'],
            ['DAILY', 'P1D'],
            ['HOURLY', 'PT1H'],
            ['MINUTELY', 'PT1M'],
            ['SECONDLY', 'PT1S'],
        ];
    }
}