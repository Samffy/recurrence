<?php

namespace Recurrence\Rrule\Extractor;

use Recurrence\Rrule\Extractor\AbstractExtractor;

/**
 * Class DtStartExtractor
 * @package Recurrence\Rrule\Extractor
 */
class DtStartExtractor extends AbstractExtractor
{
    const RRULE_PARAMETER = 'DTSTART';

    const RRULE_PATTERN = '([0-9]{8}(T[0-9]{6}Z?)?)';
}
