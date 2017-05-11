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

    /**
     * @param string $rrule
     * @return $this
     */
    public static function createRecurrenceFromRrule($rrule)
    {
        // TODO : think of a better way to do that without a static method, or at least, not in Recurrence object

        $explodedRules = explode(';', str_replace(' ', '', trim(strtoupper($rrule))));

        if (count($explodedRules) == 0 || empty($explodedRules[0])) {
            throw new \InvalidArgumentException(sprintf('Invalid RRULE [%s]', $rrule));
        }

        $rules =[];
        foreach ($explodedRules as $explodedRule) {
            $ruleParts = explode('=', $explodedRule);

            if (count($ruleParts) != 2) {
                throw new \InvalidArgumentException(sprintf('Invalid RRULE  [%s] part [%s] is incorrect', $rrule, $explodedRule));
            }

            $rules[$ruleParts[0]] = $ruleParts[1];
        }

        $recurrence = new Recurrence();

        if (isset($rules['FREQ'])) {
            $frequency = new Frequency($rules['FREQ']);

            $recurrence->setFrequency($frequency);
        } else {
            throw new \InvalidArgumentException('RRULE required [FREQ] option');
        }

        return $recurrence;
    }
}