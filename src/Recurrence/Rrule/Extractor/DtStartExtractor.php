<?php

namespace Recurrence\Rrule\Extractor;

use Recurrence\Rrule\Extractor\AbstractExtractor;

class DtStartExtractor extends AbstractExtractor
{
    public const RRULE_PARAMETER = 'DTSTART';

    public const RRULE_PATTERN = '([0-9]{8}(T[0-9]{6}Z?)?)';
}
