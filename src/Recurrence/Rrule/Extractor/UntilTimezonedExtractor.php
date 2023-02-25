<?php

namespace Recurrence\Rrule\Extractor;

/**
 * Class UntilTimezonedExtractor
 * @package Recurrence\Rrule\Extractor
 */
class UntilTimezonedExtractor extends DtStartTimezonedExtractor
{
    public const RRULE_PARAMETER = 'UNTIL;TZID';
}
