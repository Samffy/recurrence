<?php

namespace Recurrence\Rrule\Extractor;

use Recurrence\Model\Exception\InvalidRruleException;

/**
 * Interface RruleExtractorInterface
 * @package Recurrence\Rrule\Model
 */
interface RruleExtractorInterface
{
    /**
     * @param string $rRule
     * @throws InvalidRruleException
     * @return array|null
     */
    public function extract($rRule);
}
