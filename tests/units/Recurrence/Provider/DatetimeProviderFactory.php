<?php

namespace Recurrence\tests\units\Provider;

use Recurrence\Constraint\ProviderConstraint\EndOfMonthConstraint;
use Recurrence\Model\Frequency;
use Recurrence\Model\Recurrence;
use Recurrence\Provider\DatetimeProviderFactory as TestedDatetimeProviderFactory;
use Recurrence\Provider\EndOfMonthProvider;
use Recurrence\Provider\OptimizedProvider;

class DatetimeProviderFactory extends \atoum
{
    public function testStandardRecurrence(): void
    {
        $recurrence = new Recurrence(
            new Frequency(Frequency::FREQUENCY_MONTHLY),
            1,
            new \DateTime(),
            null,
            2,
        );

        $this->assert
            ->object(TestedDatetimeProviderFactory::create($recurrence))
            ->isInstanceOf(OptimizedProvider::class)
        ;
    }

    public function testRecurrenceWithEndOfMonthConstraint(): void
    {
        $recurrence = new Recurrence(
            new Frequency(Frequency::FREQUENCY_MONTHLY),
            1,
            new \DateTime('2017-01-31'),
            null,
            2,
            [new EndOfMonthConstraint()],
        );

        $this->assert
            ->object(TestedDatetimeProviderFactory::create($recurrence))
            ->isInstanceOf(EndOfMonthProvider::class)
        ;

        $recurrence = new Recurrence(
            new Frequency(Frequency::FREQUENCY_MONTHLY),
            1,
            new \DateTime('2017-01-28'),
            null,
            2,
            [new EndOfMonthConstraint()],
        );

        $this->assert
            ->object(TestedDatetimeProviderFactory::create($recurrence))
            ->isInstanceOf(OptimizedProvider::class)
        ;

        $recurrence = new Recurrence(
            new Frequency(Frequency::FREQUENCY_DAILY),
            1,
            new \DateTime('2017-01-31'),
            null,
            2,
            [new EndOfMonthConstraint()],
        );

        $this->assert
            ->object(TestedDatetimeProviderFactory::create($recurrence))
            ->isInstanceOf(OptimizedProvider::class)
        ;

        $recurrence = new Recurrence(
            new Frequency(Frequency::FREQUENCY_MONTHLY),
            1,
            new \DateTime('2017-01-31'),
            null,
            2,
        );

        $this->assert
            ->object(TestedDatetimeProviderFactory::create($recurrence))
            ->isInstanceOf(OptimizedProvider::class)
        ;
    }
}
