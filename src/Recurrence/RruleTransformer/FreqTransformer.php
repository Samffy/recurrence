<?php

namespace Recurrence\RruleTransformer;

use Recurrence\Frequency;

/**
 * Class FreqTransformer
 * @package Recurrence\RruleTransformer
 */
class FreqTransformer implements TransformerInterface
{
    /**
     * @param string $rRule
     * @return Frequency
     */
    public function transform($rRule)
    {
        if (preg_match('/FREQ=([a-zA-Z]+)/', $rRule, $matches)) {
            return new Frequency($matches[1]);
        }

        throw new \InvalidArgumentException('RRULE required [FREQ] option');
    }
}
