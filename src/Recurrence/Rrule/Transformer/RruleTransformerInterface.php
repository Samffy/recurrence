<?php

namespace Recurrence\Rrule\Transformer;

/**
 * Interface RruleTransformerInterface
 * @package Recurrence\Rrule\Model
 */
interface RruleTransformerInterface
{
    /**
     * @param array $values
     * @return mixed
     */
    public function transform($values);
}
