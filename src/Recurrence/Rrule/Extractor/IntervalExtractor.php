<?php

namespace Recurrence\Rrule\Extractor;

use Recurrence\Rrule\Extractor\AbstractExtractor;

/**
 * Class IntervalExtractor
 * @package Recurrence\Rrule\Extractor
 */
class IntervalExtractor extends AbstractExtractor
{
    public const RRULE_PARAMETER = 'INTERVAL';

    public const RRULE_PATTERN = '([0-9]+)';
}
