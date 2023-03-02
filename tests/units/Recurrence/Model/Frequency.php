<?php

namespace Recurrence\tests\units\Model;

use atoum;
use Recurrence\Model\Exception\InvalidFrequencyOptionException;

class Frequency extends atoum
{

    public function testContructor(): void
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
     */
    public function testConvertToDateIntervalFormat(string $frequencyName, string $expected): void
    {
        $frequency = (new \Recurrence\Model\Frequency($frequencyName));

        $this->assert
            ->string((string) $frequency->convertToDateIntervalFormat())
            ->isEqualTo($expected);
    }

    protected function convertToDateIntervalProvider(): array
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
     */
    public function testConvertToDateTimeFormat(string $frequencyName, string $expected): void
    {
        $frequency = (new \Recurrence\Model\Frequency($frequencyName));

        $this->assert
            ->string((string) $frequency->convertToDateTimeFormat())
            ->isEqualTo($expected);
    }

    protected function convertToDateTimeProvider(): array
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
     */
    public function testToString(string $frequencyName, string $expected): void
    {
        $frequency = (new \Recurrence\Model\Frequency($frequencyName));

        $this->assert
            ->string((string) $frequency)
            ->isEqualTo($expected);
    }

    protected function toStringProvider(): array
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
