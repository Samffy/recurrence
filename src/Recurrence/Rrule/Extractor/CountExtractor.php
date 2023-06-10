<?php

namespace Recurrence\Rrule\Extractor;

class CountExtractor extends AbstractExtractor
{
    public const RRULE_PARAMETER = 'COUNT';

    public const RRULE_PATTERN = '([0-9]+)';
}
