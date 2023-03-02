<?php

namespace Recurrence\Rrule\Extractor;

use Recurrence\Rrule\Extractor\AbstractExtractor;

class FreqExtractor extends AbstractExtractor
{
    public const RRULE_PARAMETER = 'FREQ';

    public const RRULE_PATTERN = '([a-zA-Z]+)';
}
