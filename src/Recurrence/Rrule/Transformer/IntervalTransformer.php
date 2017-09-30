<?php

namespace Recurrence\Rrule\Transformer;

use Recurrence\Model\Exception\InvalidRruleException;
use Recurrence\Rrule\Extractor\IntervalExtractor;

/**
 * Class IntervalTransformer
 * @package Recurrence\Rrule\Transformer
 */
class IntervalTransformer extends CountTransformer
{

    /**
     * @param array $values
     * @throws InvalidRruleException
     */
    protected function validate(array $values)
    {
        if (!isset($values[0]) || !is_numeric($values[0])) {
            throw new InvalidRruleException(IntervalExtractor::RRULE_PARAMETER, ((isset($values[0]))? (string) $values[0] : ''));
        }
    }
}
