<?php

namespace Recurrence\tests\units\Model;

use atoum;
use Recurrence\Constraint\ProviderConstraint\EndOfMonthConstraint;
use Recurrence\Constraint\DatetimeConstraint\ExcludeWeekendConstraint;
use Recurrence\tests\units\Constraint\DatetimeConstraint\ExcludeDaysOfWeekConstraint;

class Recurrence extends atoum
{
    public function testContructor(): void
    {
        $now = new \Datetime();

        $recurrence = new \Recurrence\Model\Recurrence();

        $this->assert
            ->object($recurrence->getPeriodStartAt())
            ->isInstanceOf(\Datetime::class)
        ;

        $this->assert
            ->string($recurrence->getPeriodStartAt()->format('Y-m-d H:i'))
            ->isEqualTo($now->format('Y-m-d H:i'))
        ;
    }

    public function testDuplicateConstraint(): void
    {
        $this->assert
            ->exception(function () {
                (new \Recurrence\Model\Recurrence())
                    ->addConstraint(new EndOfMonthConstraint())
                    ->addConstraint(new EndOfMonthConstraint())
                ;
            })
            ->isInstanceOf(\InvalidArgumentException::class)
            ->hasMessage('Duplicate constraint [Recurrence\Constraint\ProviderConstraint\EndOfMonthConstraint]')
        ;

        $this->assert
            ->exception(function () {
                (new \Recurrence\Model\Recurrence())
                    ->setConstraints([new EndOfMonthConstraint(), new EndOfMonthConstraint()])
                ;
            })
            ->isInstanceOf(\InvalidArgumentException::class)
            ->hasMessage('Duplicate constraint [Recurrence\Constraint\ProviderConstraint\EndOfMonthConstraint]')
        ;
    }

    public function testRemoveConstraint(): void
    {
        $recurrence =
            (new \Recurrence\Model\Recurrence())
                ->addConstraint(new EndOfMonthConstraint())
                ->addConstraint(new ExcludeWeekendConstraint())
        ;

        $this->assert
            ->integer(count($recurrence->getConstraints()))
            ->isEqualTo(2)
        ;

        $recurrence->removeConstraint(EndOfMonthConstraint::class);

        $this->assert
            ->integer(count($recurrence->getConstraints()))
            ->isEqualTo(1)
        ;

        $constraints = $recurrence->getConstraints();

        $this->assert
            ->object($constraints[0])
            ->isInstanceOf(ExcludeWeekendConstraint::class)
        ;
    }

    public function testHasConstraint(): void
    {
        $recurrence =
            (new \Recurrence\Model\Recurrence())
                ->addConstraint(new EndOfMonthConstraint())
                ->addConstraint(new ExcludeWeekendConstraint())
        ;

        $this->assert
            ->boolean($recurrence->hasConstraint(EndOfMonthConstraint::class))
            ->isTrue()
        ;

        $this->assert
            ->boolean($recurrence->hasConstraint(ExcludeDaysOfWeekConstraint::class))
            ->isFalse()
        ;
    }

    public function testHasConstraints(): void
    {
        $recurrence = new \Recurrence\Model\Recurrence();

        $this->assert
            ->boolean($recurrence->hasConstraints())
            ->isFalse()
        ;

        $recurrence
            ->addConstraint(new EndOfMonthConstraint())
            ->addConstraint(new ExcludeWeekendConstraint());

        $this->assert
            ->boolean($recurrence->hasConstraints())
            ->isTrue()
        ;
    }

    public function testHasProviderConstraint(): void
    {
        $recurrence = new \Recurrence\Model\Recurrence();

        $this->assert
            ->boolean($recurrence->hasProviderConstraint())
            ->isFalse()
        ;

        $recurrence
            ->addConstraint(new ExcludeWeekendConstraint());

        $this->assert
            ->boolean($recurrence->hasProviderConstraint())
            ->isFalse()
        ;

        $recurrence
            ->addConstraint(new EndOfMonthConstraint());

        $this->assert
            ->boolean($recurrence->hasProviderConstraint())
            ->isTrue()
        ;
    }

    public function testHasDatetimeConstraint(): void
    {
        $recurrence = new \Recurrence\Model\Recurrence();

        $this->assert
            ->boolean($recurrence->hasDatetimeConstraint())
            ->isFalse()
        ;

        $recurrence
            ->addConstraint(new EndOfMonthConstraint());

        $this->assert
            ->boolean($recurrence->hasDatetimeConstraint())
            ->isFalse()
        ;

        $recurrence
            ->addConstraint(new ExcludeWeekendConstraint());

        $this->assert
            ->boolean($recurrence->hasDatetimeConstraint())
            ->isTrue()
        ;
    }
}
