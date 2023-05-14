<?php

namespace Recurrence\Model;

use Recurrence\Constraint\DatetimeConstraint\DatetimeConstraintInterface;
use Recurrence\Constraint\ProviderConstraint\EndOfMonthConstraint;
use Recurrence\Constraint\ProviderConstraint\ProviderConstraintInterface;
use Recurrence\Constraint\RecurrenceConstraintInterface;
use Recurrence\Model\Exception\InvalidRecurrenceException;

class Recurrence
{
    public function __construct(
        private Frequency $frequency,
        private int $interval,
        private \Datetime $periodStartAt,
        private ?\Datetime $periodEndAt = null,
        private ?int $count = null,
        private array $constraints = []
    ) {
        if ($count && $periodEndAt) {
            throw new InvalidRecurrenceException('Recurrence cannot have [COUNT] and [UNTIL] option at the same time');
        }

        if (null === $count && null === $periodEndAt) {
            throw new InvalidRecurrenceException('Recurrence required [COUNT] or [UNTIL] option');
        }

        $constraintNames = array_map(function ($constraint) { return $constraint::class; }, $constraints);
        $duplicateConstraints = array_diff_key($constraintNames, array_unique($constraintNames));

        if (!empty($duplicateConstraints)) {
            throw new \InvalidArgumentException(sprintf('Duplicate constraint [%s]', implode(', ', $duplicateConstraints)));
        }
    }

    public function getFrequency(): ?Frequency
    {
        return $this->frequency;
    }

    public function getInterval(): int
    {
        return $this->interval;
    }

    public function getPeriodStartAt(): \Datetime
    {
        return $this->periodStartAt;
    }

    public function getPeriodEndAt(): ?\Datetime
    {
        return $this->periodEndAt;
    }

    public function hasPeriodEndAt(): bool
    {
        return $this->periodEndAt !== null;
    }

    public function getCount(): ?int
    {
        return $this->count;
    }

    public function hasCount(): bool
    {
        return $this->count !== null;
    }

    public function getConstraints(): array
    {
        return $this->constraints;
    }

    public function hasConstraints(): bool
    {
        return !empty($this->constraints);
    }

    public function hasConstraint(string $constraintClassName): bool
    {
        foreach ($this->constraints as $key => $constraint) {
            if ($constraint::class == $constraintClassName) {
                return true;
            }
        }

        return false;
    }

    public function addConstraint(RecurrenceConstraintInterface $constraint): self
    {
        if ($this->hasConstraint($constraint::class)) {
            throw new \InvalidArgumentException(sprintf('Duplicate constraint [%s]', get_class($constraint)));
        }

        if ($constraint instanceof EndOfMonthConstraint && $this->frequency->__toString() !== Frequency::FREQUENCY_MONTHLY) {
            throw new InvalidRecurrenceException('End of month constraint can be applied only with monthly frequency');
        }

        $this->constraints[] = $constraint;

        return $this;
    }

    public function removeConstraint(string $constraintClassName): self
    {
        foreach ($this->constraints as $key => $constraint) {
            if ($constraint::class == $constraintClassName) {
                unset($this->constraints[$key]);

                break;
            }
        }

        $this->constraints = array_values($this->constraints);

        return $this;
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
