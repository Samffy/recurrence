<?php

namespace Recurrence\Constraint\DatetimeConstraint;

use Recurrence\Model\Recurrence;

/**
 * Interface DatetimeConstraintInterface
 * @package Recurrence\Constraint
 */
interface DatetimeConstraintInterface
{
    /**
     * @param Recurrence $recurrence
     * @param \Datetime $datetime
     * @return \Datetime|void
     */
    public function apply(Recurrence $recurrence, \Datetime $datetime);
}
