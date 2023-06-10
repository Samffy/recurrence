<?php

namespace Recurrence\Rrule\Transformer;

use Recurrence\Model\Exception\InvalidFrequencyOptionException;
use Recurrence\Model\Exception\InvalidRruleException;
use Recurrence\Model\Frequency;
use Recurrence\Rrule\Extractor\FreqExtractor;

class FreqTransformer implements RruleTransformerInterface
{
    /**
     * @throws InvalidRruleException
     */
    public function transform(array $values): Frequency
    {
        $this->validate($values);

        try {
            return new Frequency($values[0]);
        } catch (InvalidFrequencyOptionException $e) {
            throw new InvalidRruleException(FreqExtractor::RRULE_PARAMETER, (string) $values[0]);
        }
    }

    /**
     * @throws InvalidRruleException
     */
    protected function validate(array $values): void
    {
        if (!isset($values[0])) {
            throw new InvalidRruleException(FreqExtractor::RRULE_PARAMETER);
        }
    }
}
