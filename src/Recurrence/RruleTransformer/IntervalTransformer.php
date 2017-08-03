<?php

namespace Recurrence\RruleTransformer;

/**
 * Class IntervalTransformer
 * @package Recurrence\RruleTransformer
 */
class IntervalTransformer extends AbstractRruleTransformer implements TransformerInterface
{
    const RRULE_PARAMETER = 'INTERVAL';

    /**
     * @param string $rRule
     * @return integer
     */
    public function transform($rRule)
    {
        if (preg_match('/INTERVAL=([0-9]+)/', $rRule, $matches)) {
            return (int) $matches[1];
        }

        $this->throwExceptionOnInvalidParameter($rRule, self::RRULE_PARAMETER);

        return null;
    }
}
