<?php

namespace Recurrence\Rrule\Transformer;

use Recurrence\Rrule\Extractor\CountExtractor;
use Recurrence\Model\Exception\InvalidRruleException;

class CountTransformer implements RruleTransformerInterface
{
    /**
     * @throws InvalidRruleException
     */
    public function transform(array $values): int
    {
        $this->validate($values);

        return (int) $values[0];
    }

    /**
     * @throws InvalidRruleException
     */
    protected function validate(array $values): void
    {
        if (!isset($values[0]) || !is_numeric($values[0])) {
            throw new InvalidRruleException(CountExtractor::RRULE_PARAMETER, ((isset($values[0])) ? (string) $values[0] : ''));
        }
    }
}
