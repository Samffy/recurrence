<?php

namespace Recurrence\Validator;

use Recurrence\Model\Frequency;
use Recurrence\Model\Recurrence;
use Recurrence\Constraint\ProviderConstraint\EndOfMonthConstraint;
use Recurrence\Model\Exception\InvalidRecurrenceException;

/**
 * Class RecurrenceValidator
 * @package Recurrence\Validator
 */
class RecurrenceValidator
{
    /**
     * @param Recurrence $recurrence
     * @throws InvalidRecurrenceException
     * @return bool
     */
    public static function validate(Recurrence $recurrence)
    {
        if (!$recurrence->getFrequency()) {
            throw new InvalidRecurrenceException('Frequency is required');
        }

        if ($recurrence->hasCount() && $recurrence->getPeriodEndAt()) {
            throw new InvalidRecurrenceException('Recurrence cannot have [COUNT] and [UNTIL] option at the same time');
        }

        if (!$recurrence->hasCount() && !$recurrence->getPeriodEndAt()) {
            throw new InvalidRecurrenceException('Recurrence required [COUNT] or [UNTIL] option');
        }

        if ($recurrence->hasConstraint(EndOfMonthConstraint::class) && (string) $recurrence->getFrequency() != Frequency::FREQUENCY_MONTHLY) {
            throw new InvalidRecurrenceException('End of month constraint can be applied only with monthly frequency');
        }

        return true;
    }
}
