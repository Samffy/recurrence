<?php

namespace Recurrence\tests\units\Provider;

use atoum;

use Recurrence\Constraint\ProviderConstraint\EndOfMonthConstraint;
use Recurrence\Model\Frequency;
use Recurrence\Model\Recurrence;
use Recurrence\Provider\DatetimeProviderFactory as TestedDatetimeProviderFactory;
use Recurrence\Provider\EndOfMonthProvider;
use Recurrence\Provider\OptimizedProvider;

/**
 * Class DatetimeProviderFactory
 * @package Recurrence\tests\units\Provider
 */
class DatetimeProviderFactory extends atoum
{
    public function testStandardRecurrence()
    {
        $recurrence = new Recurrence();
        $recurrence
            ->setFrequency(new Frequency(Frequency::FREQUENCY_MONTHLY))
            ->setCount(2)
        ;

        $this->assert
            ->object(TestedDatetimeProviderFactory::create($recurrence))
            ->isInstanceOf(OptimizedProvider::class)
        ;
    }

    public function testRecurrenceWithEndOfMonthConstraint()
    {
        $recurrence = new Recurrence();
        $recurrence
            ->setFrequency(new Frequency(Frequency::FREQUENCY_MONTHLY))
            ->setPeriodStartAt(new \DateTime('2017-01-31'))
            ->setCount(2)
            ->addConstraint(new EndOfMonthConstraint())
        ;

        $this->assert
            ->object(TestedDatetimeProviderFactory::create($recurrence))
            ->isInstanceOf(EndOfMonthProvider::class)
        ;

        $recurrence = new Recurrence();
        $recurrence
            ->setFrequency(new Frequency(Frequency::FREQUENCY_MONTHLY))
            ->setPeriodStartAt(new \DateTime('2017-01-28'))
            ->setCount(2)
            ->addConstraint(new EndOfMonthConstraint())
        ;

        $this->assert
            ->object(TestedDatetimeProviderFactory::create($recurrence))
            ->isInstanceOf(OptimizedProvider::class)
        ;

        $recurrence = new Recurrence();
        $recurrence
            ->setFrequency(new Frequency(Frequency::FREQUENCY_DAILY))
            ->setPeriodStartAt(new \DateTime('2017-01-31'))
            ->setCount(2)
            ->addConstraint(new EndOfMonthConstraint())
        ;

        $this->assert
            ->object(TestedDatetimeProviderFactory::create($recurrence))
            ->isInstanceOf(OptimizedProvider::class)
        ;

        $recurrence = new Recurrence();
        $recurrence
            ->setFrequency(new Frequency(Frequency::FREQUENCY_MONTHLY))
            ->setPeriodStartAt(new \DateTime('2017-01-31'))
            ->setCount(2)
        ;

        $this->assert
            ->object(TestedDatetimeProviderFactory::create($recurrence))
            ->isInstanceOf(OptimizedProvider::class)
        ;
    }
}
