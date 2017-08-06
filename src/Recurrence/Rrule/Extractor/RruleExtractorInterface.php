<?php

namespace Recurrence\Rrule\Extractor;

/**
 * Interface RruleExtractorInterface
 * @package Recurrence\Rrule\Model
 */
interface RruleExtractorInterface
{
    /**
     * @param string $rRule
     * @throws \InvalidArgumentException
     * @return array|null
     */
    public function extract($rRule);
}
