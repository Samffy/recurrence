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

        // If there is a FREQ option but transformer was not able to get it, assume it was an invalid option
        if (preg_match('/FREQ=/', $rRule, $matches)) {
            throw new \InvalidArgumentException('RRULE invalid [FREQ] option');
        }

        throw new \InvalidArgumentException('RRULE required [FREQ] option');
    }
}
