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
     * @var FreqTransformer
     */
    private $freqTransformer;

    /**
     * @var DtStartTransformer
     */
    private $dtStartTransformer;

    /**
     * @var UntilTransformer
     */
    private $untilTransformer;

    /**
     * @var IntervalTransformer
     */
    private $intervalTransformer;

    /**
     * RecurrenceProvider constructor.
     */
    public function __construct()
    {
        $this->freqTransformer     = new FreqTransformer();
        $this->dtStartTransformer  = new DtStartTransformer();
        $this->untilTransformer    = new UntilTransformer();
        $this->intervalTransformer = new IntervalTransformer();
        $this->countTransformer    = new CountTransformer();
    }

    /**
     * @param string $rRule
     * @return Recurrence
     * @throws \InvalidArgumentException
     */
    public function parse($rRule)
    {
        if (empty($rRule)) {
            throw new \InvalidArgumentException('Empty RRULE');
        }

        $recurrence = new Recurrence();

        $recurrence->setFrequency($this->freqTransformer->transform($rRule));

        if ($periodStartAt = $this->dtStartTransformer->transform($rRule)) {
            $recurrence->setPeriodStartAt($periodStartAt);
        }

        if ($periodStartAt = $this->untilTransformer->transform($rRule)) {
            $recurrence->setPeriodEndAt($periodStartAt);
        }

        if ($interval = $this->intervalTransformer->transform($rRule)) {
            $recurrence->setInterval($interval);
        }

        if ($interval = $this->countTransformer->transform($rRule)) {
            $recurrence->setCount($interval);
        }

        if ($recurrence->hasCount() && $recurrence->getPeriodEndAt()) {
            throw new \InvalidArgumentException('Recurrence cannot have [UNTIL] and [COUNT] option at the same time');
        }

        if (!$recurrence->hasCount() && !$recurrence->getPeriodEndAt()) {
            throw new \InvalidArgumentException('Recurrence required an [UNTIL] or [COUNT] option');
        }

        return $recurrence;
    }
}
