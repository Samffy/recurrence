<?php

namespace Recurrence\RruleTransformer;

/**
 * Interface TransformerInterface
 * @package Recurrence\RruleTransformer
 */
interface TransformerInterface
{
    /**
     * @param string $rRule
     * @return mixed
     */
    public function transform($rRule);
}
