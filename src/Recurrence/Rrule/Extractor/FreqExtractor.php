<?php

namespace Recurrence\Rrule\Extractor;

class FreqExtractor extends AbstractExtractor
{
    public const RRULE_PARAMETER = 'FREQ';

    public const RRULE_PATTERN = '([a-zA-Z]+)';
}
