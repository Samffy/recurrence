<?php

namespace Recurrence\RruleTransformer;

use Recurrence\Frequency;

/**
 * Class FreqTransformer
 * @package Recurrence\RruleTransformer
 */
class FreqTransformer extends AbstractRruleTransformer implements TransformerInterface
{
    const RRULE_PARAMETER = 'FREQ';

    const RRULE_PATTERN = '([a-zA-Z]+)';

    /**
     * @param string $rRule
     * @throws \InvalidArgumentException
     * @return Frequency|null
     */
    public function transform($rRule)
    {
        $value = parent::transform($rRule);

        return ($value) ? new Frequency($value) : null;
    }
}
