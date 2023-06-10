<?php

namespace Recurrence\tests\units\Model;

use Recurrence\Constraint\DatetimeConstraint\ExcludeWeekendConstraint;
use Recurrence\Constraint\ProviderConstraint\EndOfMonthConstraint;
use Recurrence\Model\Frequency;
use Recurrence\tests\units\Constraint\DatetimeConstraint\ExcludeDaysOfWeekConstraint;

class Recurrence extends \atoum
{
    public function testContructor(): void
    {
        $now = new \DateTime();

        $recurrence = new \Recurrence\Model\Recurrence(
            new Frequency('MONTHLY'),
            1,
            new \DateTime(),
            null,
            2,
        );

        $this->assert
            ->object($recurrence->getPeriodStartAt())
            ->isInstanceOf(\DateTime::class)
        ;

        $this->assert
            ->string($recurrence->getPeriodStartAt()->format('Y-m-d H:i'))
            ->isEqualTo($now->format('Y-m-d H:i'))
        ;
    }

    public function testDuplicateConstraint(): void
    {
        $this->assert
            ->exception(static function () {
                $recurrence = new \Recurrence\Model\Recurrence(
                    new Frequency('MONTHLY'),
                    1,
                    new \DateTime(),
                    null,
                    10,
                    [new EndOfMonthConstraint(), new EndOfMonthConstraint()],
                );
            })
            ->isInstanceOf(\InvalidArgumentException::class)
            ->hasMessage('Duplicate constraint [Recurrence\Constraint\ProviderConstraint\EndOfMonthConstraint]')
        ;

        $this->assert
            ->exception(static function () {
                $recurrence = new \Recurrence\Model\Recurrence(
                    new Frequency('MONTHLY'),
                    1,
                    new \DateTime(),
                    null,
                    10,
                    [new EndOfMonthConstraint(), new EndOfMonthConstraint()],
                );
            })
            ->isInstanceOf(\InvalidArgumentException::class)
            ->hasMessage('Duplicate constraint [Recurrence\Constraint\ProviderConstraint\EndOfMonthConstraint]')
        ;
    }

    public function testRemoveConstraint(): void
    {
        $recurrence = new \Recurrence\Model\Recurrence(
            new Frequency('MONTHLY'),
            1,
            new \DateTime(),
            null,
            10,
            [new EndOfMonthConstraint(), new ExcludeWeekendConstraint()],
        );

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
        $recurrence = new \Recurrence\Model\Recurrence(
            new Frequency('MONTHLY'),
            1,
            new \DateTime(),
            null,
            10,
            [new EndOfMonthConstraint(), new ExcludeWeekendConstraint()],
        );

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
        $recurrence = new \Recurrence\Model\Recurrence(
            new Frequency('MONTHLY'),
            1,
            new \DateTime(),
            new \DateTime(),
        );

        $this->assert
            ->boolean($recurrence->hasConstraints())
            ->isFalse()
        ;

        $recurrence
            ->addConstraint(new EndOfMonthConstraint())
            ->addConstraint(new ExcludeWeekendConstraint())
        ;

        $this->assert
            ->boolean($recurrence->hasConstraints())
            ->isTrue()
        ;
    }

    public function testHasProviderConstraint(): void
    {
        $recurrence = new \Recurrence\Model\Recurrence(
            new Frequency('MONTHLY'),
            1,
            new \DateTime(),
            new \DateTime(),
        );

        $this->assert
            ->boolean($recurrence->hasProviderConstraint())
            ->isFalse()
        ;

        $recurrence
            ->addConstraint(new ExcludeWeekendConstraint())
        ;

        $this->assert
            ->boolean($recurrence->hasProviderConstraint())
            ->isFalse()
        ;

        $recurrence
            ->addConstraint(new EndOfMonthConstraint())
        ;

        $this->assert
            ->boolean($recurrence->hasProviderConstraint())
            ->isTrue()
        ;
    }

    public function testHasDatetimeConstraint(): void
    {
        $recurrence = new \Recurrence\Model\Recurrence(
            new Frequency('MONTHLY'),
            1,
            new \DateTime(),
            new \DateTime(),
        );

        $this->assert
            ->boolean($recurrence->hasDatetimeConstraint())
            ->isFalse()
        ;

        $recurrence
            ->addConstraint(new EndOfMonthConstraint())
        ;

        $this->assert
            ->boolean($recurrence->hasDatetimeConstraint())
            ->isFalse()
        ;

        $recurrence
            ->addConstraint(new ExcludeWeekendConstraint())
        ;

        $this->assert
            ->boolean($recurrence->hasDatetimeConstraint())
            ->isTrue()
        ;
    }
}
