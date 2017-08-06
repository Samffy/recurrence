<?php

namespace Recurrence\Rrule\Transformer;

use Recurrence\Rrule\Extractor\DtStartExtractor;

/**
 * Class DtStartTransformer
 * @package Recurrence\Rrule\Transformer
 */
class DtStartTransformer implements RruleTransformerInterface
{
    /**
     * @param array $values
     * @return \DateTime
     * @throws \InvalidArgumentException
     */
    public function transform($values)
    {
        try {
            if (count($values) == 2 && substr($values[1], -1) == 'Z') {
                return \DateTime::createFromFormat('Ymd\THis\Z', $values[0], new \DateTimeZone('UTC'));
            } else if (count($values) == 2) {
                return \DateTime::createFromFormat('Ymd\THis', $values[0]);
            } else {
                return \DateTime::createFromFormat('Ymd', $values[0]);
            }
        } catch (\Exception $e) {
            throw new \InvalidArgumentException(sprintf('Invalid RRULE [%s] option : [%s]', DtStartExtractor::RRULE_PARAMETER, $values[0]));
        }
    }
}
