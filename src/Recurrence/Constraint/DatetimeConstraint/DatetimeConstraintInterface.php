<?php

namespace Recurrence\Constraint\DatetimeConstraint;

use Recurrence\Model\Recurrence;

interface DatetimeConstraintInterface
{
    public function apply(Recurrence $recurrence, \DateTime $datetime): \DateTime|null;
}
