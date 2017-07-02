<?php

namespace Recurrence\RruleTransformer;

/**
 * Class CountTransformer
 * @package Recurrence\RruleTransformer
 */
class CountTransformer implements TransformerInterface
{
    /**
     * @param string $rRule
     * @return integer
     */
    public function transform($rRule)
    {
        if (preg_match('/COUNT=([0-9]+)/', $rRule, $matches)) {
            return (int) $matches[1];
        }

        // If there is an INTERVAL option but transformer was not able to get it, assume it was an invalid option
        if (preg_match('/COUNT=/', $rRule, $matches)) {
            throw new \InvalidArgumentException('RRULE invalid [COUNT] option');
        }

        return null;
    }
}
