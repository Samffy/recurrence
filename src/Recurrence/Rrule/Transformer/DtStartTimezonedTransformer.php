<?php

namespace Recurrence\Rrule\Transformer;

use Recurrence\Rrule\Extractor\DtStartTimezonedExtractor;
use Recurrence\Model\Exception\InvalidRruleException;

/**
 * Class DtStartTimezonedTransformer
 * @package Recurrence\Rrule\Transformer
 */
class DtStartTimezonedTransformer implements RruleTransformerInterface
{
    /**
     * @throws InvalidRruleException
     */
    public function transform(array $values): \DateTime
    {
        $this->validate($values);

        $dtStart = \DateTime::createFromFormat('Ymd\THis', $values[1], new \DateTimeZone($values[0]));

        if (!$dtStart) {
            throw new InvalidRruleException(DtStartTimezonedExtractor::RRULE_PARAMETER, implode(', ', $values));
        }

        return $dtStart;
    }

    /**
     * @throws InvalidRruleException
     */
    protected function validate(array $values): void
    {
        if (!isset($values[0]) || !isset($values[1])) {
            throw new InvalidRruleException(DtStartTimezonedExtractor::RRULE_PARAMETER);
        }

        try {
            new \DateTimeZone($values[0]);
        } catch (\Exception $e) {
            throw new InvalidRruleException(DtStartTimezonedExtractor::RRULE_PARAMETER, (string) $values[0]);
        }
    }
}
