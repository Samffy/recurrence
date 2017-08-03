<?php

namespace Recurrence\RruleTransformer;

/**
 * Class DtStartTransformer
 * @package Recurrence\RruleTransformer
 */
class DtStartTransformer extends AbstractRruleTransformer implements TransformerInterface
{
    const RRULE_PARAMETER = 'DTSTART';

    /**
     * @var array
     */
    private $datePatterns = [
        [
            'pattern'     => '[0-9]{8}T[0-9]{6}Z',
            'date_format' => 'Ymd\THisZ',
            'timezone'    => 'UTC',
        ],
        [
            'pattern'     => '[0-9]{8}T[0-9]{6}',
            'date_format' => 'Ymd\THis',
            'timezone'    => null,
        ],
        [
            'pattern'     => '[0-9]{8}',
            'date_format' => 'Ymd',
            'timezone'    => null,
        ],
    ];

    /**
     * @param string $rRule
     * @return \DateTime
     */
    public function transform($rRule)
    {
        if (preg_match('/'.$this::RRULE_PARAMETER.';TZID=([a-zA-Z_-]+[\/[a-zA-Z_+\-0-9]+]?):([0-9]{8}T[0-9]{6})/', $rRule, $matches)) {
            try {
                return $this->createDate('Ymd\THis', $matches[2], new \DateTimeZone($matches[1]));
            } catch (\Exception $e) {
                throw new \InvalidArgumentException(sprintf('Invalid RRULE [%s] option : [%s] with timezone [%s]', $this::RRULE_PARAMETER, $matches[2], $matches[1]));
            }
        }

        // Process each supported date patterns and try to create \Datetime
        foreach ($this->datePatterns as $datePattern) {
            if (preg_match(sprintf('/%s=(%s)/', $this::RRULE_PARAMETER, $datePattern['pattern']), $rRule, $matches)) {
                return $this->createDate(
                    $datePattern['date_format'],
                    $matches[1],
                    (($datePattern['timezone']) ? new \DateTimeZone($datePattern['timezone']) : new \DateTimeZone(date_default_timezone_get()))
                );
            }
        }

        $this->throwExceptionOnInvalidParameter($rRule, $this::RRULE_PARAMETER);

        return null;
    }

    /**
     * @param string        $format
     * @param string        $time
     * @param \DateTimeZone $timezone
     * @return \DateTime|null
     */
    private function createDate($format, $time, \DateTimeZone $timezone)
    {
        $date = \DateTime::createFromFormat($format, $time, $timezone);

        return ($date) ? $date : null;
    }
}
