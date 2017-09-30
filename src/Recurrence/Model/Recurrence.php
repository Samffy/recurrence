<?php

namespace Recurrence\Model;


/**
 * Class Recurrence
 * @package Recurrence\Model
 */
class Recurrence
{
    /**
     * @var Frequency
     */
    private $frequency;

    /**
     * @var \Datetime
     */
    private $periodStartAt;

    /**
     * @var \Datetime
     */
    private $periodEndAt;

    /**
     * @var integer
     */
    private $interval = 1;

    /**
     * @var integer
     */
    private $count;

    /**
     * Recurrence constructor.
     */
    public function __construct()
    {
        $this->setPeriodStartAt(new \DateTime());
    }

    /**
     * @param \Datetime $periodStartAt
     * @return $this
     */
    public function setPeriodStartAt(\Datetime $periodStartAt)
    {
        $this->periodStartAt = $periodStartAt;

        return $this;
    }

    /**
     * @return \Datetime
     */
    public function getPeriodStartAt()
    {
        return $this->periodStartAt;
    }

    /**
     * @param \Datetime $periodEndAt
     * @return $this
     */
    public function setPeriodEndAt(\Datetime $periodEndAt)
    {
        $this->periodEndAt = $periodEndAt;

        return $this;
    }

    /**
     * @return \Datetime
     */
    public function getPeriodEndAt()
    {
        return $this->periodEndAt;
    }

    /**
     * @return bool
     */
    public function hasPeriodEndAt()
    {
        return $this->periodEndAt !== null;
    }

    /**
     * @param Frequency $frequency
     * @return $this
     */
    public function setFrequency(Frequency $frequency)
    {
        $this->frequency = $frequency;

        return $this;
    }

    /**
     * @return Frequency
     */
    public function getFrequency()
    {
        return $this->frequency;
    }

    /**
     * @return int
     */
    public function getInterval()
    {
        return $this->interval;
    }

    /**
     * @param int $interval
     * @return $this
     */
    public function setInterval($interval)
    {
        $this->interval = $interval;

        return $this;
    }

    /**
     * @return int
     */
    public function getCount()
    {
        return $this->count;
    }

    /**
     * @return bool
     */
    public function hasCount()
    {
        return $this->count !== null;
    }

    /**
     * @param int $count
     * @return $this
     */
    public function setCount($count)
    {
        $this->count = $count;

        return $this;
    }
}
