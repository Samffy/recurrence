<?php

namespace Recurrence\Rrule\Extractor;

use Recurrence\Model\Exception\InvalidRruleException;

/**
 * Class AbstractExtractor
 * @package Recurrence\Rrule\Model
 */
abstract class AbstractExtractor implements RruleExtractorInterface
{
    /**
     * @param string $rRule
     * @throws InvalidRruleException
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
     * @throws InvalidRruleException
     * @return void
     */
    public function throwExceptionOnInvalidParameter($rRule, $ruleKey)
    {
        if ((preg_match(sprintf('/%s=([\d\w]+)/', $ruleKey), $rRule, $matches) === 1)) {
            throw new InvalidRruleException($ruleKey, ((count($matches) > 0) ? implode(', ', array_slice($matches, 1)) : ''));
        }
    }
}
