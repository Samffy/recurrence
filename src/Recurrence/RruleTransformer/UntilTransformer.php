<?php

namespace Recurrence\RruleTransformer;

/**
 * Class UntilTransformer
 */
class UntilTransformer extends DtStartTransformer
{
    const RRULE_PARAMETER = 'UNTIL';

    /**
     * @param string $rRule
     * @return \DateTime
     */
    public function transform($rRule)
    {
        return parent::transform($rRule);
    }
}
