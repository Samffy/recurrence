<?php

namespace Recurrence\Model;

use Recurrence\Model\Exception\InvalidFrequencyOptionException;

/**
 * Class Frequency
 * @package Recurrence\Model
 */
class Frequency
{
    public const FREQUENCY_YEARLY   = 'YEARLY';
    public const FREQUENCY_MONTHLY  = 'MONTHLY';
    public const FREQUENCY_WEEKLY   = 'WEEKLY';
    public const FREQUENCY_DAILY    = 'DAILY';
    public const FREQUENCY_HOURLY   = 'HOURLY';
    public const FREQUENCY_MINUTELY = 'MINUTELY';
    public const FREQUENCY_SECONDLY = 'SECONDLY';

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

    public const DATEINTERVAL_YEARLY   = 'P1Y';
    public const DATEINTERVAL_MONTHLY  = 'P1M';
    public const DATEINTERVAL_WEEKLY   = 'P1W';
    public const DATEINTERVAL_DAILY    = 'P1D';
    public const DATEINTERVAL_HOURLY   = 'PT1H';
    public const DATEINTERVAL_MINUTELY = 'PT1M';
    public const DATEINTERVAL_SECONDLY = 'PT1S';

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

    public const DATETIME_YEARLY   = '+1 years';
    public const DATETIME_MONTHLY  = '+1 months';
    public const DATETIME_WEEKLY   = '+1 weeks';
    public const DATETIME_DAILY    = '+1 days';
    public const DATETIME_HOURLY   = '+1 hours';
    public const DATETIME_MINUTELY = '+1 minutes';
    public const DATETIME_SECONDLY = '+1 seconds';

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
            throw new InvalidFrequencyOptionException(sprintf('Invalid frequency name. Supported values are : %s', implode(', ', $this->frequencies)));
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
