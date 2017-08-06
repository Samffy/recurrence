<?php

namespace Recurrence\Rrule\Extractor;

/**
 * Class AbstractExtractor
 * @package Recurrence\Rrule\Model
 */
abstract class AbstractExtractor implements RruleExtractorInterface
{
    /**
     * @param string $rRule
     * @throws \InvalidArgumentException
     * @return array|null
     */
    public function extract($rRule)
    {
        if (preg_match(sprintf('/%s=%s/', $this::RRULE_PARAMETER, $this::RRULE_PATTERN), $rRule, $matches)) {
            return array_slice($matches, 1);
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
            throw new \InvalidArgumentException(sprintf('Invalid RRULE [%s] option', $ruleKey));
        }
    }
}
