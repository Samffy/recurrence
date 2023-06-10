<?php

namespace Recurrence\Rrule\Transformer;

use Recurrence\Model\Exception\InvalidRruleException;
use Recurrence\Rrule\Extractor\IntervalExtractor;

class IntervalTransformer extends CountTransformer
{
    /**
     * @throws InvalidRruleException
     */
    protected function validate(array $values): void
    {
        if (!isset($values[0]) || !is_numeric($values[0])) {
            throw new InvalidRruleException(IntervalExtractor::RRULE_PARAMETER, (isset($values[0])) ? (string) $values[0] : '');
        }
    }
}
