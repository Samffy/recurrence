<?php

namespace Recurrence\RruleTransformer;

/**
 * Class IntervalTransformer
 * @package Recurrence\RruleTransformer
 */
class IntervalTransformer implements TransformerInterface
{
    /**
     * @param string $rRule
     * @return integer
     */
    public function transform($rRule)
    {
        if (preg_match('/INTERVAL=([0-9]+)/', $rRule, $matches)) {
            return (int) $matches[1];
        }

        // If there is an INTERVAL option but transformer was not able to get it, assume it was an invalid option
        if (preg_match('/INTERVAL=/', $rRule, $matches)) {
            throw new \InvalidArgumentException('RRULE invalid [INTERVAL] option');
        }

        return null;
    }
}
