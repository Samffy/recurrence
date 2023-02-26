<?php

namespace Recurrence\Rrule\Extractor;

use Recurrence\Model\Exception\InvalidRruleException;

interface RruleExtractorInterface
{
    /**
     * @throws InvalidRruleException
     */
    public function extract(string $rRule): ?array;
}
