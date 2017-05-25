<?php

namespace Recurrence\RruleTransformer;

/**
 * Class DtStartTransformer
 * @package Recurrence\RruleTransformer
 */
class DtStartTransformer implements TransformerInterface
{
    const RRULE_PARAMETER = 'DTSTART';

    /**
     * @param string $rRule
     * @return \DateTime
     */
    public function transform($rRule)
    {
        if (preg_match('/'.$this::RRULE_PARAMETER.';TZID=([a-zA-Z_-]+[\/[a-zA-Z_+\-0-9]+]?):([0-9]{8}T[0-9]{6})/', $rRule, $matches)) {
            try {
                return \DateTime::createFromFormat('Ymd\THis', $matches[2], new \DateTimeZone($matches[1]));
            } catch (\Exception $e) {
                throw new \InvalidArgumentException(sprintf('Invalid RRULE [%s] option : [%s] with timezone [%s]', $this::RRULE_PARAMETER, $matches[2], $matches[1]));
            }
        }

        if (preg_match('/'.$this::RRULE_PARAMETER.'=([0-9]{8}T[0-9]{6}Z)/', $rRule, $matches)) {
            return \DateTime::createFromFormat('Ymd\THisZ', $matches[1], new \DateTimeZone('UTC'));
        }

        if (preg_match('/'.$this::RRULE_PARAMETER.'=([0-9]{8}T[0-9]{6})/', $rRule, $matches)) {
            return \DateTime::createFromFormat('Ymd\THis', $matches[1]);
        }

        if (preg_match('/'.$this::RRULE_PARAMETER.'=([0-9]{8})/', $rRule, $matches)) {
            return \DateTime::createFromFormat('Ymd', $matches[1]);
        }

        // If there is the search option but transformer was not able to get it, assume it was an invalid option
        if (preg_match('/'.$this::RRULE_PARAMETER.'/', $rRule, $matches)) {
            throw new \InvalidArgumentException(sprintf('RRULE invalid [%s] option', $this::RRULE_PARAMETER));
        }

        return null;
    }
}
