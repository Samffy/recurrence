<?php

namespace Recurrence\RruleTransformer;

/**
 * Class AbstractRruleTransformer
 * @package Recurrence\RruleTransformer
 */
abstract class AbstractRruleTransformer
{
    /**
     * @param string $rRule
     * @throws \InvalidArgumentException
     * @return mixed
     */
    public function transform($rRule)
    {
        if (preg_match(sprintf('/%s=%s/', $this::RRULE_PARAMETER, $this::RRULE_PATTERN), $rRule, $matches)) {
            return (is_numeric($matches[1])) ? (int) $matches[1] : $matches[1];
        }

        $this->throwExceptionOnInvalidParameter($rRule, $this::RRULE_PARAMETER);

        return null;
    }

    /**
     * @param string $rRule
     * @param string $ruleKey
     * @throws \InvalidArgumentException
     * @return void
     */
    public function throwExceptionOnInvalidParameter($rRule, $ruleKey)
    {
        if ((preg_match(sprintf('/%s=/', $ruleKey), $rRule, $matches) === 1)) {
            throw new \InvalidArgumentException(sprintf('RRULE invalid [%s] option', $ruleKey));
        }
    }
}
