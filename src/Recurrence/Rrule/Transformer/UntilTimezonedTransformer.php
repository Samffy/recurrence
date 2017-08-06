<?php

namespace Recurrence\Rrule\Transformer;

use Recurrence\Rrule\Extractor\UntilTimezonedExtractor;

/**
 * Class UntilTimezonedTransformer
 * @package Recurrence\Rrule\Transformer
 */
class UntilTimezonedTransformer extends DtStartTimezonedTransformer
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
            throw new \InvalidArgumentException(sprintf(
                'Invalid RRULE [%s] option : [%s] with timezone [%s]',
                UntilTimezonedExtractor::RRULE_PARAMETER,
                $values[1],
                $values[0]
            ));
        }
    }
}
