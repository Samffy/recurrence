<?php

namespace Recurrence;

/**
 * Class Recurrence
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
}
