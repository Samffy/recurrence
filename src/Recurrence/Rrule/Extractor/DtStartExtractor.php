<?php

namespace Recurrence\Rrule\Extractor;

use Recurrence\Rrule\Extractor\AbstractExtractor;

/**
 * Class DtStartExtractor
 * @package Recurrence\Rrule\Extractor
 */
class DtStartExtractor extends AbstractExtractor
{
    public const RRULE_PARAMETER = 'DTSTART';

    public const RRULE_PATTERN = '([0-9]{8}(T[0-9]{6}Z?)?)';
}
