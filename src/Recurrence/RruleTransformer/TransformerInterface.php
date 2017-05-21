<?php

namespace Recurrence\RruleTransformer;

/**
 * Interface TransformerInterface
 */
interface TransformerInterface
{
    /**
     * @param string $rRule
     * @return mixed
     */
    public function transform($rRule);
}
