<?php

namespace Recurrence\RruleTransformer;

/**
 * Class CountTransformer
 * @package Recurrence\RruleTransformer
 */
class CountTransformer extends AbstractRruleTransformer implements TransformerInterface
{
    const RRULE_PARAMETER = 'COUNT';

    /**
     * @param string $rRule
     * @return integer
     */
    public function transform($rRule)
    {
        if (preg_match('/COUNT=([0-9]+)/', $rRule, $matches)) {
            return (int) $matches[1];
        }

        $this->throwExceptionOnInvalidParameter($rRule, self::RRULE_PARAMETER);

        return null;
    }
}
