<?php

namespace Recurrence\tests\units\Provider;

use atoum;

use Recurrence\Model\Frequency;
use Recurrence\Model\Recurrence;
use Recurrence\Provider\OptimizedProvider;

/**
 * Class AbstractDatetimeProvider
 * @package Recurrence\tests\units\Provider
 */
class AbstractDatetimeProvider extends atoum
{
    public function testEstimatePeriodEndAt()
    {
        $provider = new OptimizedProvider();

        // With COUNT option
        $recurrence = new Recurrence();
        $recurrence
            ->setFrequency(new Frequency(Frequency::FREQUENCY_MONTHLY))
            ->setPeriodStartAt(new \Datetime('2017-01-01 00:00:00'))
            ->setCount(2)
        ;

        $this->assert
            ->object($provider->estimatePeriodEndAt($recurrence))
            ->isInstanceOf(\DateTime::class)
            ->object($provider->estimatePeriodEndAt($recurrence))
            ->isEqualTo(new \Datetime('2017-03-01 00:00:00'))
        ;

        // Without COUNT option
        $recurrence = new Recurrence();
        $recurrence
            ->setFrequency(new Frequency(Frequency::FREQUENCY_MONTHLY))
            ->setPeriodStartAt(new \Datetime('2017-01-01 00:00:00'))
            ->setPeriodEndAt(new \Datetime('2017-03-02 13:37:00'))
        ;

        $this->assert
            ->object($provider->estimatePeriodEndAt($recurrence))
            ->isInstanceOf(\DateTime::class)
            ->object($provider->estimatePeriodEndAt($recurrence))
            ->isEqualTo(new \Datetime('2017-03-02 13:37:00'))
        ;
    }
}
