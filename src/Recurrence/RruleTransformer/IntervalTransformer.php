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

        return null;
    }
}
