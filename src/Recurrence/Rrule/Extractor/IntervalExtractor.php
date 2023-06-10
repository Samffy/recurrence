<?php

namespace Recurrence\Rrule\Extractor;

class IntervalExtractor extends AbstractExtractor
{
    public const RRULE_PARAMETER = 'INTERVAL';

    public const RRULE_PATTERN = '([0-9]+)';
}
