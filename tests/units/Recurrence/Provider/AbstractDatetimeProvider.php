<?php

namespace Recurrence\tests\units\Provider;

use Recurrence\Model\Frequency;
use Recurrence\Model\Recurrence;
use Recurrence\Provider\OptimizedProvider;

class AbstractDatetimeProvider extends \atoum
{
    public function testEstimatePeriodEndAt(): void
    {
        $provider = new OptimizedProvider();

        // With COUNT option
        $recurrence = new Recurrence(
            new Frequency(Frequency::FREQUENCY_MONTHLY),
            1,
            new \DateTime('2017-01-01 00:00:00'),
            null,
            2,
        );

        $this->assert
            ->object($provider->estimatePeriodEndAt($recurrence))
            ->isInstanceOf(\DateTime::class)
            ->object($provider->estimatePeriodEndAt($recurrence))
            ->isEqualTo(new \DateTime('2017-03-01 00:00:00'))
        ;

        // Without COUNT option
        $recurrence = new Recurrence(
            new Frequency(Frequency::FREQUENCY_MONTHLY),
            1,
            new \DateTime('2017-01-01 00:00:00'),
            new \DateTime('2017-03-02 13:37:00'),
        );

        $this->assert
            ->object($provider->estimatePeriodEndAt($recurrence))
            ->isInstanceOf(\DateTime::class)
            ->object($provider->estimatePeriodEndAt($recurrence))
            ->isEqualTo(new \DateTime('2017-03-02 13:37:00'))
        ;
    }
}
