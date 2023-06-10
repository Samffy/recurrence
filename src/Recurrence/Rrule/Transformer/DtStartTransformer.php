<?php

namespace Recurrence\Rrule\Transformer;

use Recurrence\Model\Exception\InvalidRruleException;
use Recurrence\Rrule\Extractor\DtStartExtractor;

class DtStartTransformer implements RruleTransformerInterface
{
    /**
     * @throws InvalidRruleException
     */
    public function transform(array $values): \DateTime
    {
        $this->validate($values);

        if (2 == count($values) && 'Z' == substr($values[1], -1)) {
            $dtStart = \DateTime::createFromFormat('Ymd\THis\Z', $values[0], new \DateTimeZone('UTC'));
        } elseif (2 == count($values)) {
            $dtStart = \DateTime::createFromFormat('Ymd\THis', $values[0]);
        } else {
            $dtStart = \DateTime::createFromFormat('Ymd', $values[0]);
        }

        if (false === $dtStart) {
            throw new InvalidRruleException(DtStartExtractor::RRULE_PARAMETER, (string) $values[0]);
        }

        return $dtStart;
    }

    /**
     * @throws InvalidRruleException
     */
    protected function validate(array $values): void
    {
        if (!isset($values[0])) {
            throw new InvalidRruleException(DtStartExtractor::RRULE_PARAMETER);
        }
    }
}
