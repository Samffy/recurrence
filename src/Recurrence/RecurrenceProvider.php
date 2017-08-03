<?php

namespace Recurrence;

use Recurrence\RruleTransformer\CountTransformer;
use Recurrence\RruleTransformer\DtStartTransformer;
use Recurrence\RruleTransformer\FreqTransformer;
use Recurrence\RruleTransformer\IntervalTransformer;
use Recurrence\RruleTransformer\UntilTransformer;

/**
 * Class RecurrenceProvider
 * @package Recurrence
 */
class RecurrenceProvider
{

    /**
     * @var array
     */
    private $transformers;

    /**
     * RecurrenceProvider constructor.
     */
    public function __construct()
    {
        $this->transformers = [
            'frequency'     => new FreqTransformer(),
            'periodStartAt' => new DtStartTransformer(),
            'periodEndAt'   => new UntilTransformer(),
            'interval'      => new IntervalTransformer(),
            'count'         => new CountTransformer(),
        ];
    }

    /**
     * @param string $rRule
     * @return Recurrence
     * @throws \InvalidArgumentException
     */
    public function create($rRule)
    {
        if (empty($rRule)) {
            throw new \InvalidArgumentException('Empty RRULE');
        }

        $recurrence = new Recurrence();

        // Process each transformer and set value if available in RRULE expression
        foreach ($this->transformers as $attribute => $transformer) {
            if ($value = $transformer->transform($rRule)) {
                $recurrence = $this->setAttribute($recurrence, $attribute, $value);
            }
        }

        if (!$recurrence->getFrequency()) {
            throw new \InvalidArgumentException(sprintf('Recurrence [%s] option is required', FreqTransformer::RRULE_PARAMETER));
        }

        if ($recurrence->hasCount() && $recurrence->getPeriodEndAt()) {
            throw new \InvalidArgumentException(sprintf('Recurrence cannot have [%s] and [%s] option at the same time', UntilTransformer::RRULE_PARAMETER, CountTransformer::RRULE_PARAMETER));
        }

        if (!$recurrence->hasCount() && !$recurrence->getPeriodEndAt()) {
            throw new \InvalidArgumentException(sprintf('Recurrence required an [%s] or [%s] option', UntilTransformer::RRULE_PARAMETER, CountTransformer::RRULE_PARAMETER));
        }

        return $recurrence;
    }

    /**
     * @param Recurrence $recurrence
     * @param string     $attribute
     * @param mixed      $value
     * @return Recurrence
     */
    private function setAttribute(Recurrence $recurrence, $attribute, $value)
    {
        $method = sprintf('set%s', ucfirst($attribute));

        if (method_exists($recurrence, $method)) {
            $recurrence->$method($value);
        }

        return $recurrence;
    }
}
