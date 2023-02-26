<?php

namespace Recurrence\Model;

use Recurrence\Constraint\DatetimeConstraint\DatetimeConstraintInterface;
use Recurrence\Constraint\ProviderConstraint\ProviderConstraintInterface;
use Recurrence\Constraint\RecurrenceConstraintInterface;

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
    private $periodEndAt = null;

    /**
     * @var integer
     */
    private $interval = 1;

    /**
     * @var integer
     */
    private $count = null;

    /**
     * @var array
     */
    private $constraints = [];

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

    /**
     * @return array
     */
    public function getConstraints()
    {
        return $this->constraints;
    }

    /**
     * @param array $constraints
     * @return $this
     */
    public function setConstraints(array $constraints)
    {
        $this->constraints = [];

        foreach ($constraints as $constraint) {
            $this->addConstraint($constraint);
        }

        return $this;
    }

    /**
     * @return bool
     */
    public function hasConstraints()
    {
        return !empty($this->constraints);
    }

    /**
     * @param RecurrenceConstraintInterface $constraint
     * @return $this
     */
    public function addConstraint(RecurrenceConstraintInterface $constraint)
    {
        if ($this->hasConstraint(get_class($constraint))) {
            throw new \InvalidArgumentException(sprintf('Duplicate constraint [%s]', get_class($constraint)));
        }

        $this->constraints[] = $constraint;

        return $this;
    }

    /**
     * @param string $constraintClassName
     * @return $this
     */
    public function removeConstraint($constraintClassName)
    {
        foreach ($this->constraints as $key => $constraint) {
            if (get_class($constraint) == $constraintClassName) {
                unset($this->constraints[$key]);

                break;
            }
        }

        $this->constraints = array_values($this->constraints);

        return $this;
    }

    /**
     * @param string $constraintClassName
     * @return bool
     */
    public function hasConstraint($constraintClassName)
    {
        foreach ($this->constraints as $key => $constraint) {
            if (get_class($constraint) == $constraintClassName) {
                return true;
            }
        }

        return false;
    }

    /**
     * @return bool
     */
    public function hasProviderConstraint()
    {
        foreach ($this->constraints as $key => $constraint) {
            if ($constraint instanceof ProviderConstraintInterface) {
                return true;
            }
        }

        return false;
    }

    /**
     * @return bool
     */
    public function hasDatetimeConstraint()
    {
        foreach ($this->constraints as $key => $constraint) {
            if ($constraint instanceof DatetimeConstraintInterface) {
                return true;
            }
        }

        return false;
    }
}
