<?php

namespace Recurrence\RruleTransformer;

interface TransformerInterface
{
    /**
     * @param string $rRule
     * @return mixed
     */
    public function transform($rRule);
}