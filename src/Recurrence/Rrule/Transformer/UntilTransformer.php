<?php

namespace Recurrence\Rrule\Transformer;

use Recurrence\Model\Exception\InvalidRruleException;
use Recurrence\Rrule\Extractor\UntilExtractor;

class UntilTransformer extends DtStartTransformer
{
    /**
     * @throws InvalidRruleException
     */
    public function transform(array $values): \DateTime
    {
        $this->validate($values);

        try {
            return parent::transform($values);
        } catch (\Exception $e) {
            throw new InvalidRruleException(UntilExtractor::RRULE_PARAMETER, (string) $values[0]);
        }
    }

    /**
     * @throws InvalidRruleException
     */
    protected function validate(array $values): void
    {
        if (!isset($values[0])) {
            throw new InvalidRruleException(UntilExtractor::RRULE_PARAMETER);
        }
    }
}
