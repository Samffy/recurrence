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
    private $frequencies = [
        self::DATEINTERVAL_YEARLY   => self::FREQUENCY_YEARLY,
        self::DATEINTERVAL_MONTHLY  => self::FREQUENCY_MONTHLY,
        self::DATEINTERVAL_WEEKLY   => self::FREQUENCY_WEEKLY,
        self::DATEINTERVAL_DAILY    => self::FREQUENCY_DAILY,
        self::DATEINTERVAL_HOURLY   => self::FREQUENCY_HOURLY,
        self::DATEINTERVAL_MINUTELY => self::FREQUENCY_MINUTELY,
        self::DATEINTERVAL_SECONDLY => self::FREQUENCY_SECONDLY,
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
        return array_search($this->frequencyName, $this->frequencies);
    }

    /**
     * @return string
     */
    public function __toString()
    {
        return $this->frequencyName;
    }
}
