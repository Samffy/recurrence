<?php

namespace Recurrence\Validator;

use Recurrence\Model\Recurrence;
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

        return true;
    }
}
