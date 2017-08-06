<?php

namespace Recurrence\Rrule\Transformer;

use Recurrence\Model\Frequency;

/**
 * Class FreqTransformer
 * @package Recurrence\RruleTransformer
 */
class FreqTransformer implements RruleTransformerInterface
{
    /**
     * @param array $values
     * @throws \InvalidArgumentException
     * @return Frequency
     */
    public function transform($values)
    {
        return new Frequency($values[0]);
    }
}
