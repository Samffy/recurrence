<?php

namespace Recurrence\RruleTransformer;

/**
 * Class UntilTransformer
 * @package Recurrence\RruleTransformer
 */
class UntilTransformer extends DtStartTransformer
{
    const RRULE_PARAMETER = 'UNTIL';

    const RRULE_PATTERN = null;

    /**
     * @param string $rRule
     * @return \DateTime|null
     */
    public function transform($rRule)
    {
        return parent::transform($rRule);
    }
}
