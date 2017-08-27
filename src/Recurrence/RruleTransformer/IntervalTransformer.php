<?php

namespace Recurrence\RruleTransformer;

/**
 * Class IntervalTransformer
 * @package Recurrence\RruleTransformer
 */
class IntervalTransformer extends AbstractRruleTransformer implements TransformerInterface
{
    const RRULE_PARAMETER = 'INTERVAL';

    const RRULE_PATTERN = '([0-9]+)';
}
