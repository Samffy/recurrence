<?php

namespace Recurrence\Rrule\Transformer;

use Recurrence\Rrule\Extractor\CountExtractor;
use Recurrence\Model\Exception\InvalidRruleException;

/**
 * Class CountTransformer
 * @package Recurrence\RruleTransformer
 */
class CountTransformer implements RruleTransformerInterface
{
    /**
     * @param array $values
     * @throws InvalidRruleException
     * @return int
     */
    public function transform(array $values)
    {
        $this->validate($values);

        return (int) $values[0];
    }

    /**
     * @param array $values
     * @throws InvalidRruleException
     */
    protected function validate(array $values)
    {
        if (!isset($values[0]) || !is_numeric($values[0])) {
            throw new InvalidRruleException(CountExtractor::RRULE_PARAMETER, ((isset($values[0])) ? (string) $values[0] : ''));
        }
    }
}
