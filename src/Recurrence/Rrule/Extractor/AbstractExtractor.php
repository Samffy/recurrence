<?php

namespace Recurrence\Rrule\Extractor;

use Recurrence\Model\Exception\InvalidRruleException;

abstract class AbstractExtractor implements RruleExtractorInterface
{
    public const RRULE_PARAMETER = '';
    public const RRULE_PATTERN = '';

    /**
     * @throws InvalidRruleException
     */
    public function extract(string $rRule): ?array
    {
        if (preg_match(sprintf('/%s=%s/', $this::RRULE_PARAMETER, $this::RRULE_PATTERN), $rRule, $matches)) {
            return array_slice($matches, 1);
        }

        $this->throwExceptionOnInvalidParameter($rRule, $this::RRULE_PARAMETER);

        return null;
    }

    /**
     * @throws InvalidRruleException
     */
    public function throwExceptionOnInvalidParameter(string $rRule, string $ruleKey): void
    {
        if (1 === preg_match(sprintf('/%s=([\d\w]+)/', $ruleKey), $rRule, $matches)) {
            throw new InvalidRruleException($ruleKey, (count($matches) > 0) ? implode(', ', array_slice($matches, 1)) : '');
        }
    }
}
