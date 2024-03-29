<?php

namespace Recurrence\Rrule\Transformer;

use Recurrence\Rrule\Extractor\DtStartExtractor;
use Recurrence\Model\Exception\InvalidRruleException;

class DtStartTransformer implements RruleTransformerInterface
{
    /**
     * @throws InvalidRruleException
     */
    public function transform(array $values): \DateTime
    {
        $this->validate($values);

        if (count($values) == 2 && substr($values[1], -1) == 'Z') {
            $dtStart = \DateTime::createFromFormat('Ymd\THis\Z', $values[0], new \DateTimeZone('UTC'));
        } elseif (count($values) == 2) {
            $dtStart = \DateTime::createFromFormat('Ymd\THis', $values[0]);
        } else {
            $dtStart = \DateTime::createFromFormat('Ymd', $values[0]);
        }

        if ($dtStart === false) {
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
