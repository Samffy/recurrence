<?php

namespace Recurrence\Rrule\Transformer;

use Recurrence\Rrule\Extractor\UntilTimezonedExtractor;
use Recurrence\Model\Exception\InvalidRruleException;

class UntilTimezonedTransformer extends DtStartTimezonedTransformer
{
    /**
     * @throws InvalidRruleException
     */
    public function transform(array $values): \DateTime
    {
        $this->validate($values);

        try {
            return parent::transform($values);
        } catch (InvalidRruleException $e) {
            throw new InvalidRruleException(UntilTimezonedExtractor::RRULE_PARAMETER, implode(', ', $values));
        }
    }

    /**
     * @throws InvalidRruleException
     */
    protected function validate(array $values): void
    {
        if (!isset($values[0]) || !isset($values[1])) {
            throw new InvalidRruleException(UntilTimezonedExtractor::RRULE_PARAMETER);
        }

        try {
            new \DateTimeZone($values[0]);
        } catch (\Exception $e) {
            throw new InvalidRruleException(UntilTimezonedExtractor::RRULE_PARAMETER, (string) $values[0]);
        }
    }
}
