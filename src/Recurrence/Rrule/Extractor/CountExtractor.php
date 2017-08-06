<?php

namespace Recurrence\Rrule\Extractor;

use Recurrence\Rrule\Extractor\AbstractExtractor;

/**
 * Class CountExtractor
 * @package Recurrence\Rrule\Extractor
 */
class CountExtractor extends AbstractExtractor
{
    const RRULE_PARAMETER = 'COUNT';

    const RRULE_PATTERN = '([0-9]+)';
}
