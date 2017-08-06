<?php

namespace Recurrence\Rrule\Transformer;

/**
 * Class CountTransformer
 * @package Recurrence\RruleTransformer
 */
class CountTransformer implements RruleTransformerInterface
{
    /**
     * @param array $values
     * @throws \InvalidArgumentException
     * @return int
     */
    public function transform($values)
    {
        return (int) $values[0];
    }
}
