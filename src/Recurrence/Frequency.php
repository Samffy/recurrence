<?php

namespace Recurrence;

/**
 * Class Frequency
 * @package Recurrence
 */
class Frequency
{
    const FREQUENCY_YEARLY   = 'YEARLY';
    const FREQUENCY_MONTHLY  = 'MONTHLY';
    const FREQUENCY_WEEKLY   = 'WEEKLY';
    const FREQUENCY_DAILY    = 'DAILY';
    const FREQUENCY_HOURLY   = 'HOURLY';
    const FREQUENCY_MINUTELY = 'MINUTELY';
    const FREQUENCY_SECONDLY = 'SECONDLY';

    /**
     * @var array
     */
    private $frequencies = [
        self::FREQUENCY_YEARLY,
        self::FREQUENCY_MONTHLY,
        self::FREQUENCY_WEEKLY,
        self::FREQUENCY_DAILY,
        self::FREQUENCY_HOURLY,
        self::FREQUENCY_MINUTELY,
        self::FREQUENCY_SECONDLY,
    ];

    const DATEINTERVAL_YEARLY   = 'P1Y';
    const DATEINTERVAL_MONTHLY  = 'P1M';
    const DATEINTERVAL_WEEKLY   = 'P1W';
    const DATEINTERVAL_DAILY    = 'P1D';
    const DATEINTERVAL_HOURLY   = 'PT1H';
    const DATEINTERVAL_MINUTELY = 'PT1M';
    const DATEINTERVAL_SECONDLY = 'PT1S';

    /**
     * @var array
     */
    private $dateIntervalFrequencies = [
        self::FREQUENCY_YEARLY   => self::DATEINTERVAL_YEARLY,
        self::FREQUENCY_MONTHLY  => self::DATEINTERVAL_MONTHLY,
        self::FREQUENCY_WEEKLY   => self::DATEINTERVAL_WEEKLY,
        self::FREQUENCY_DAILY    => self::DATEINTERVAL_DAILY,
        self::FREQUENCY_HOURLY   => self::DATEINTERVAL_HOURLY,
        self::FREQUENCY_MINUTELY => self::DATEINTERVAL_MINUTELY,
        self::FREQUENCY_SECONDLY => self::DATEINTERVAL_SECONDLY,
    ];

    const DATETIME_YEARLY   = '+1 years';
    const DATETIME_MONTHLY  = '+1 months';
    const DATETIME_WEEKLY   = '+1 weeks';
    const DATETIME_DAILY    = '+1 days';
    const DATETIME_HOURLY   = '+1 hours';
    const DATETIME_MINUTELY = '+1 minutes';
    const DATETIME_SECONDLY = '+1 seconds';

    /**
     * @var array
     */
    private $dateTimeFrequencies = [
        self::FREQUENCY_YEARLY   => self::DATETIME_YEARLY,
        self::FREQUENCY_MONTHLY  => self::DATETIME_MONTHLY,
        self::FREQUENCY_WEEKLY   => self::DATETIME_WEEKLY,
        self::FREQUENCY_DAILY    => self::DATETIME_DAILY,
        self::FREQUENCY_HOURLY   => self::DATETIME_HOURLY,
        self::FREQUENCY_MINUTELY => self::DATETIME_MINUTELY,
        self::FREQUENCY_SECONDLY => self::DATETIME_SECONDLY,
    ];

    /**
     * @var string
     */
    private $frequencyName;

    /**
     * @param string $frequencyName
     */
    public function __construct($frequencyName)
    {
        if (!in_array($frequencyName, $this->frequencies)) {
            throw new \InvalidArgumentException(sprintf('Invalid frequency name. Supported values are : %s', implode(', ', $this->frequencies)));
        }

        $this->frequencyName = $frequencyName;
    }

    /**
     * @return string
     */
    public function convertToDateIntervalFormat()
    {
        return $this->dateIntervalFrequencies[$this->frequencyName];
    }

    /**
     * @return string
     */
    public function convertToDateTimeFormat()
    {
        return $this->dateTimeFrequencies[$this->frequencyName];
    }

    /**
     * @return string
     */
    public function __toString()
    {
        return $this->frequencyName;
    }
}
