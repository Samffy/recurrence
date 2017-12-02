<?php

namespace Recurrence\Rrule\Extractor;

use Recurrence\Rrule\Extractor\AbstractExtractor;

/**
 * Class IntervalExtractor
 * @package Recurrence\Rrule\Extractor
 */
class IntervalExtractor extends AbstractExtractor
{
    const RRULE_PARAMETER = 'INTERVAL';

    const RRULE_PATTERN = '([0-9]+)';
}
