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

    /**
     * @param string $rRule
     * @return Frequency
     */
    public function transform($rRule)
    {
        if (preg_match('/FREQ=([a-zA-Z]+)/', $rRule, $matches)) {
            return new Frequency($matches[1]);
        }

        $this->throwExceptionOnInvalidParameter($rRule, self::RRULE_PARAMETER);

        return null;
    }
}
