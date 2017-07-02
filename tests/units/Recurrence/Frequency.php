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
            ->isInstanceOf(\InvalidArgumentException::class)
        ;
    }

    /**
     * Validate get DateInterval format from frequency for each supported frequency
     *
     * @dataProvider DateIntervalFrequenciesDataProvider
     *
     * @param string $frequencyName
     * @param string $expectedDateIntervalName
     */
    public function testDateIntervalFrequencies($frequencyName, $expectedDateIntervalName)
    {
        $frequency = new \Recurrence\Frequency($frequencyName);

        $this->assert
            ->string($frequency->convertToDateIntervalFormat())
            ->isEqualTo($expectedDateIntervalName);
    }

    /**
     * Validate get DateTime format from frequency for each supported frequency
     *
     * @dataProvider DateTimeFrequenciesDataProvider
     *
     * @param string $frequencyName
     * @param string $expectedDateTimeName
     */
    public function testDateTimeFrequencies($frequencyName, $expectedDateTimeName)
    {
        $frequency = new \Recurrence\Frequency($frequencyName);

        $this->assert
            ->string($frequency->convertToDateTimeFormat())
            ->isEqualTo($expectedDateTimeName);
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
    protected function DateIntervalFrequenciesDataProvider()
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

    /**
     * @return array
     */
    protected function DateTimeFrequenciesDataProvider()
    {
        return [
            ['YEARLY', '+1 years'],
            ['MONTHLY', '+1 months'],
            ['WEEKLY', '+1 weeks'],
            ['DAILY', '+1 days'],
            ['HOURLY', '+1 hours'],
            ['MINUTELY', '+1 minutes'],
            ['SECONDLY', '+1 seconds'],
        ];
    }
}