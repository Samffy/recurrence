<?php

namespace Recurrence\tests\units\Validator;

use atoum;

use Recurrence\Model\Exception\InvalidRecurrenceException;
use Recurrence\Model\Frequency;
use Recurrence\Model\Recurrence;
use Recurrence\Validator\RecurrenceValidator as TestedRecurrenceValidator;

/**
 * Class RecurrenceValidator
 * @package Recurrence\tests\units\Validator
 */
class RecurrenceValidator extends atoum
{
    public function testValidRecurrence()
    {
        $recurrence = new Recurrence();
        $recurrence->setFrequency(new Frequency('MONTHLY'));
        $recurrence->setCount(2);

        $this->assert
            ->boolean(TestedRecurrenceValidator::validate($recurrence))
            ->isTrue()
        ;
    }

    public function testInvalidRecurrence()
    {
        // Missing FREQ option
        $this->assert
            ->exception(function () {
                $recurrence = new Recurrence();
                $recurrence->setCount(2);

                TestedRecurrenceValidator::validate($recurrence);
            })
            ->isInstanceOf(InvalidRecurrenceException::class)
            ->hasMessage('Frequency is required')
        ;

        // Conflict between COUNT and UNTIL option
        $this->assert
            ->exception(function () {
                $recurrence = new Recurrence();
                $recurrence
                    ->setFrequency(new Frequency('MONTHLY'))
                    ->setPeriodEndAt(new \Datetime())
                    ->setCount(2);

                TestedRecurrenceValidator::validate($recurrence);
            })
            ->isInstanceOf(InvalidRecurrenceException::class)
            ->hasMessage('Recurrence cannot have [COUNT] and [UNTIL] option at the same time')
        ;

        // Missing COUNT or UNTIL option
        $this->assert
            ->exception(function () {
                $recurrence = new Recurrence();
                $recurrence->setFrequency(new Frequency('MONTHLY'));

                TestedRecurrenceValidator::validate($recurrence);
            })
            ->isInstanceOf(InvalidRecurrenceException::class)
            ->hasMessage('Recurrence required [COUNT] or [UNTIL] option')
        ;
    }
}