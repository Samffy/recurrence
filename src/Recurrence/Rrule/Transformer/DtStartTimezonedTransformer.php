<?php

namespace Recurrence\Rrule\Transformer;

use Recurrence\Rrule\Extractor\DtStartTimezonedExtractor;

/**
 * Class DtStartTimezonedTransformer
 * @package Recurrence\Rrule\Transformer
 */
class DtStartTimezonedTransformer implements RruleTransformerInterface
{
    /**
     * @param array $values
     * @return \DateTime
     * @throws \InvalidArgumentException
     */
    public function transform($values)
    {
        try {
            return \DateTime::createFromFormat('Ymd\THis', $values[1], new \DateTimeZone($values[0]));
        } catch (\Exception $e) {
            throw new \InvalidArgumentException(sprintf(
                'Invalid RRULE [%s] option : [%s] with timezone [%s]',
                DtStartTimezonedExtractor::RRULE_PARAMETER,
                $values[1],
                $values[0]
            ));
        }
    }
}
