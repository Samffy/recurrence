<?php

namespace Recurrence\Rrule\Transformer;

interface RruleTransformerInterface
{
    /**
     * @return mixed
     */
    public function transform(array $values);
}
