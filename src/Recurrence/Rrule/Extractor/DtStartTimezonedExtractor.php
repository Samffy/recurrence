<?php

namespace Recurrence\Rrule\Extractor;

class DtStartTimezonedExtractor extends AbstractExtractor
{
    public const RRULE_PARAMETER = 'DTSTART;TZID';

    public const RRULE_PATTERN = '([a-zA-Z_-]+[\/[a-zA-Z_+\-0-9]+]?):([0-9]{8}T[0-9]{6})';
}
