<?php

namespace Recurrence\Rrule\Extractor;

use Recurrence\Rrule\Extractor\AbstractExtractor;

class CountExtractor extends AbstractExtractor
{
    public const RRULE_PARAMETER = 'COUNT';

    public const RRULE_PATTERN = '([0-9]+)';
}
