<?php

namespace Recurrence\Rrule\Transformer;

use Recurrence\Model\Frequency;
use Recurrence\Rrule\Extractor\FreqExtractor;
use Recurrence\Model\Exception\InvalidRruleException;
use Recurrence\Model\Exception\InvalidFrequencyOptionException;

/**
 * Class FreqTransformer
 * @package Recurrence\RruleTransformer
 */
class FreqTransformer implements RruleTransformerInterface
{
    /**
     * @param array $values
     * @throws InvalidRruleException
     * @return Frequency
     */
    public function transform(array $values)
    {
        $this->validate($values);

        try {
            return new Frequency($values[0]);
        } catch (InvalidFrequencyOptionException $e) {
            throw new InvalidRruleException(FreqExtractor::RRULE_PARAMETER, (string) $values[0]);
        }
    }

    /**
     * @param array $values
     * @throws InvalidRruleException
     */
    protected function validate(array $values)
    {
        if (!isset($values[0])) {
            throw new InvalidRruleException(FreqExtractor::RRULE_PARAMETER);
        }
    }
}
