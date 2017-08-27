<?php

namespace Recurrence\RruleTransformer;

/**
 * Class CountTransformer
 * @package Recurrence\RruleTransformer
 */
class CountTransformer extends AbstractRruleTransformer implements TransformerInterface
{
    const RRULE_PARAMETER = 'COUNT';

    const RRULE_PATTERN = '([0-9]+)';
}
