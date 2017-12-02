<?php

namespace Recurrence\Rrule\Extractor;

use Recurrence\Rrule\Extractor\AbstractExtractor;

/**
 * Class DtStartTimezonedExtractor
 * @package Recurrence\Rrule\Extractor
 */
class DtStartTimezonedExtractor extends AbstractExtractor
{
    const RRULE_PARAMETER = 'DTSTART;TZID';

    const RRULE_PATTERN = '([a-zA-Z_-]+[\/[a-zA-Z_+\-0-9]+]?):([0-9]{8}T[0-9]{6})';
}
