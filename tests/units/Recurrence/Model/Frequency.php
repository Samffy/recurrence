<?php

namespace Recurrence\tests\units\Model;

use atoum;
use Recurrence\Model\Exception\InvalidFrequencyOptionException;

/**
 * Class Frequency
 * @package Recurrence\tests\units\Model
 */
class Frequency extends atoum
{

    public function testContructor()
    {
        $this->assert
            ->exception(function () {
                (new \Recurrence\Model\Frequency('RANDOMLY'));
            })
            ->isInstanceOf(InvalidFrequencyOptionException::class)
            ->hasMessage('Invalid frequency name. Supported values are : YEARLY, MONTHLY, WEEKLY, DAILY, HOURLY, MINUTELY, SECONDLY')
        ;
    }

    /**
     * @dataProvider convertToDateIntervalProvider
     *
     * @param string $frequencyName
     * @param string $expected
     */
    public function testConvertToDateIntervalFormat($frequencyName, $expected)
    {
        $frequency = (new \Recurrence\Model\Frequency($frequencyName));

        $this->assert
            ->string((string) $frequency->convertToDateIntervalFormat())
            ->isEqualTo($expected);
    }

    /**
     * @return array
     */
    protected function convertToDateIntervalProvider()
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
     * @dataProvider convertToDateTimeProvider
     *
     * @param string $frequencyName
     * @param string $expected
     */
    public function testConvertToDateTimeFormat($frequencyName, $expected)
    {
        $frequency = (new \Recurrence\Model\Frequency($frequencyName));

        $this->assert
            ->string((string) $frequency->convertToDateTimeFormat())
            ->isEqualTo($expected);
    }

    /**
     * @return array
     */
    protected function convertToDateTimeProvider()
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

    /**
     * @dataProvider toStringProvider
     *
     * @param string $frequencyName
     * @param string $expected
     */
    public function testToString($frequencyName, $expected)
    {
        $frequency = (new \Recurrence\Model\Frequency($frequencyName));

        $this->assert
            ->string((string) $frequency)
            ->isEqualTo($expected);
    }

    /**
     * @return array
     */
    protected function toStringProvider()
    {
        return [
            ['YEARLY', 'YEARLY'],
            ['MONTHLY', 'MONTHLY'],
            ['WEEKLY', 'WEEKLY'],
            ['DAILY', 'DAILY'],
            ['HOURLY', 'HOURLY'],
            ['MINUTELY', 'MINUTELY'],
            ['SECONDLY', 'SECONDLY'],
        ];
    }
}
