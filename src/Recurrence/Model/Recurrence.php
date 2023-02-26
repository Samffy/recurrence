<?php

namespace Recurrence\Model;

use Recurrence\Constraint\DatetimeConstraint\DatetimeConstraintInterface;
use Recurrence\Constraint\ProviderConstraint\ProviderConstraintInterface;
use Recurrence\Constraint\RecurrenceConstraintInterface;

class Recurrence
{
    private ?Frequency $frequency = null;
    private \Datetime $periodStartAt;
    private ?\Datetime $periodEndAt = null;
    private int $interval = 1;
    private ?int $count = null;
    private array $constraints = [];

    public function __construct()
    {
        $this->setPeriodStartAt(new \DateTime());
    }

    public function setPeriodStartAt(\Datetime $periodStartAt): self
    {
        $this->periodStartAt = $periodStartAt;

        return $this;
    }

    public function getPeriodStartAt(): \Datetime
    {
        return $this->periodStartAt;
    }

    public function setPeriodEndAt(\Datetime $periodEndAt): self
    {
        $this->periodEndAt = $periodEndAt;

        return $this;
    }

    public function getPeriodEndAt(): ?\Datetime
    {
        return $this->periodEndAt;
    }

    public function hasPeriodEndAt(): bool
    {
        return $this->periodEndAt !== null;
    }

    public function setFrequency(Frequency $frequency): self
    {
        $this->frequency = $frequency;

        return $this;
    }

    public function getFrequency(): ?Frequency
    {
        return $this->frequency;
    }

    public function getInterval(): int
    {
        return $this->interval;
    }

    public function setInterval(int $interval): self
    {
        $this->interval = $interval;

        return $this;
    }

    public function getCount(): ?int
    {
        return $this->count;
    }

    public function hasCount(): bool
    {
        return $this->count !== null;
    }

    public function setCount(int $count): self
    {
        $this->count = $count;

        return $this;
    }

    public function getConstraints(): array
    {
        return $this->constraints;
    }

    public function setConstraints(array $constraints): self
    {
        $this->constraints = [];

        foreach ($constraints as $constraint) {
            $this->addConstraint($constraint);
        }

        return $this;
    }

    public function hasConstraints(): bool
    {
        return !empty($this->constraints);
    }

    public function addConstraint(RecurrenceConstraintInterface $constraint): self
    {
        if ($this->hasConstraint(get_class($constraint))) {
            throw new \InvalidArgumentException(sprintf('Duplicate constraint [%s]', get_class($constraint)));
        }

        $this->constraints[] = $constraint;

        return $this;
    }

    public function removeConstraint(string $constraintClassName): self
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

    public function hasConstraint(string $constraintClassName): bool
    {
        foreach ($this->constraints as $key => $constraint) {
            if (get_class($constraint) == $constraintClassName) {
                return true;
            }
        }

        return false;
    }

    public function hasProviderConstraint(): bool
    {
        foreach ($this->constraints as $key => $constraint) {
            if ($constraint instanceof ProviderConstraintInterface) {
                return true;
            }
        }

        return false;
    }

    public function hasDatetimeConstraint(): bool
    {
        foreach ($this->constraints as $key => $constraint) {
            if ($constraint instanceof DatetimeConstraintInterface) {
                return true;
            }
        }

        return false;
    }
}
