<?php

namespace Recurrence\Rrule\Transformer;

use Recurrence\Rrule\Extractor\UntilExtractor;
use Recurrence\Model\Exception\InvalidRruleException;

/**
 * Class UntilTransformer
 * @package Recurrence\Rrule\Transformer
 */
class UntilTransformer extends DtStartTransformer
{
    /**
     * @param array $values
     * @return \DateTime
     * @throws InvalidRruleException
     */
    public function transform(array $values)
    {
        $this->validate($values);

        try {
            return parent::transform($values);
        } catch (\Exception $e) {
            throw new InvalidRruleException(UntilExtractor::RRULE_PARAMETER, (string) $values[0]);
        }
    }

    /**
     * @param array $values
     * @throws InvalidRruleException
     */
    protected function validate(array $values)
    {
        if (!isset($values[0])) {
            throw new InvalidRruleException(UntilExtractor::RRULE_PARAMETER);
        }
    }
}
