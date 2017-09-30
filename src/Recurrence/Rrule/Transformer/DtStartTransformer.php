<?php

namespace Recurrence\Rrule\Transformer;

use Recurrence\Rrule\Extractor\DtStartExtractor;
use Recurrence\Model\Exception\InvalidRruleException;

/**
 * Class DtStartTransformer
 * @package Recurrence\Rrule\Transformer
 */
class DtStartTransformer implements RruleTransformerInterface
{
    /**
     * @param array $values
     * @return \DateTime
     * @throws InvalidRruleException
     */
    public function transform(array $values)
    {
        $this->validate($values);

        if (count($values) == 2 && substr($values[1], -1) == 'Z') {
            $dtStart = \DateTime::createFromFormat('Ymd\THis\Z', $values[0], new \DateTimeZone('UTC'));
        } else if (count($values) == 2) {
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
     * @param array $values
     * @throws InvalidRruleException
     */
    protected function validate(array $values)
    {
        if (!isset($values[0])) {
            throw new InvalidRruleException(DtStartExtractor::RRULE_PARAMETER);
        }
    }
}
