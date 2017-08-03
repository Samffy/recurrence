<?php

namespace Recurrence\RruleTransformer;

/**
 * Class AbstractRruleTransformer
 * @package Recurrence\RruleTransformer
 */
class AbstractRruleTransformer
{
    /**
     * @param string $rRule
     * @param string $ruleKey
     * @return bool
     */
    public function throwExceptionOnInvalidParameter($rRule, $ruleKey)
    {
        if ((preg_match(sprintf('/%s=/', $ruleKey), $rRule, $matches) === 1)) {
            throw new \InvalidArgumentException(sprintf('RRULE invalid [%s] option', $ruleKey));
        }
    }
}
