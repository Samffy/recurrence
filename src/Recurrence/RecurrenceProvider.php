<?php

namespace Recurrence;

use Recurrence\RruleTransformer\DtStartTransformer;
use Recurrence\RruleTransformer\FreqTransformer;
use Recurrence\RruleTransformer\UntilTransformer;

class RecurrenceProvider
{

    public function __construct()
    {
        $this->freqTransformer    = new FreqTransformer();
        $this->dtStartTransformer = new DtStartTransformer();
        $this->untilTransformer   = new UntilTransformer();
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

        return $recurrence;
    }

}