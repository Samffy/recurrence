<?php

namespace Recurrence\Rrule\Transformer;

use Recurrence\Rrule\Extractor\UntilExtractor;

/**
 * Class UntilTransformer
 * @package Recurrence\Rrule\Transformer
 */
class UntilTransformer extends DtStartTransformer
{
    /**
     * @param array $values
     * @return \DateTime
     * @throws \InvalidArgumentException
     */
    public function transform($values)
    {
        try {
            return parent::transform($values);
        } catch (\Exception $e) {
            throw new \InvalidArgumentException(sprintf('Invalid RRULE [%s] option : [%s]', UntilExtractor::RRULE_PARAMETER, $values[0]));
        }
    }
}
