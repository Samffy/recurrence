# Recurrence

[![License: MIT](https://img.shields.io/badge/License-MIT-blue.svg)](https://opensource.org/licenses/MIT) 
![Build Status](https://github.com/Samffy/recurrence/actions/workflows/ci.yml/badge.svg?branch=master)
[![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/Samffy/recurrence/badges/quality-score.png?b=master)](https://scrutinizer-ci.com/g/Samffy/recurrence/?branch=master)
[![Code Coverage](https://scrutinizer-ci.com/g/Samffy/recurrence/badges/coverage.png?b=master)](https://scrutinizer-ci.com/g/Samffy/recurrence/?branch=master)

## Presentation

This library allow to manage datetime recurrences. It implement basic RRULE standards and add constraints support. 

RFC : https://tools.ietf.org/html/rfc5545#page-37

## Usage

### Create recurrences using object method

```php
$frequency = new Frequency(Frequency::FREQUENCY_MONTHLY);
$interval = 1;
$periodStartAt = new \DateTime('2017-01-01');
$periodEndAt = new \DateTime('2017-12-31');
$count = null;
$constraints = [];


$recurrence = new Recurrence(
    $frequency,
    $interval,
    $periodStartAt,
    $periodEndAt,
    $count,
    $constraints
);

$periods = (new \Recurrence\DatetimeProvider())->provide($recurrence);
```

Parameters:
- `$frequency` (`Frequency`): Determine the recurrence period (daily, weekly, ...).
- `$interval` (`integer`): Interval base on the frequency (a monthly frequency with an interval of `2` mean every 2 months).
- `$periodStartAt` (`DateTime`): Recurrence period start at.
- `$periodEndAt` (`DateTime`, nullable): Recurrence period end at.
- `$count` (`integer`, nullable): Limit the number of recurrence.
- `$constraints` (`RecurrenceConstraintInterface[]`): Some additional constraints that help you to manage some useful cases.

### Create recurrences from RRULE standard expression

This example as the same result as example above using object method :

```php
$recurrence = (new RecurrenceProvider())->create('FREQ=MONTHLY;DTSTART=20170101;UNTIL=20171231;INTERVAL=1');
$periods    = (new DatetimeProvider())->provide($recurrence);
```

Supported rules : 
- `FREQ` : `YEARLY`, `MONTHLY`, `WEEKLY`, `DAILY`, `HOURLY`, `MINUTELY`, `SECONDLY`
- `DTSTART` : 
    - Simple date : `string` using format `YYYYMMDD` (example : `20170520`)
    - Datetime : `string` using format `YYYYMMDDTHHMMSS` (example : `20170520T154720`)
    - Datetime UTC : `string` using format `YYYYMMDDTHHMMSSZ` (example : `20170520T154720Z`)
- `DTSTART` with `TZID` : `string` using format `{timezone}:YYYYMMDDTHHMMSS`  (example : `Europe/Paris:20170520T154720`)
- `UNTIL` : 
    - Simple date : `string` using format `YYYYMMDD` (example : `20170520`)
    - Datetime : `string` using format `YYYYMMDDTHHMMSS` (example : `20170520T154720`)
    - Datetime UTC : `string` using format `YYYYMMDDTHHMMSSZ` (example : `20170520T154720Z`)
- `UNTIL` with `TZID` : `string` using format `{timezone}:YYYYMMDDTHHMMSS`  (example : `Europe/Paris:20170520T154720`)
- `INTERVAL` : simple `integer`
- `COUNT` : simple `integer`

### Adding constraints

You can add some constraint to `Recurrence` in order to manage more precisely generated datetimes.  
For example, if you do not want to generate datetime on wednesday (day `3` according to date format in PHP), add this constraint : 

* `EndOfMonthConstraint` : if recurrence has `MONTHLY` frequency and start date is last day of current month, force last day of month for all datetimes
* `ExcludeDaysOfWeekConstraint` : if datetime is concerned, `DatetimeProvider` will return next valid date
* `ExcludeWeekendConstraint` : if datetime is concerned, `DatetimeProvider` will return next monday

Constraints are not a part of RRULE standard, this is an addition to optimize datetimes manipulation.  
Be careful, constraints will be applied in the order you add it to recurrence.

### Unit tests

```
./vendor/bin/atoum -d tests/units/Recurrence
```

Html code coverage is generated here : `./var/code-coverage`

Remember that you need `xdebug` to generate code coverage report.

### Benchmark

To assume that you don't degrade performance when you update the library, run a benchmark using context name `initial` first :

```
./vendor/bin/phpbench run --store --tag="initial" --report=default
```

Before committing your changes, run a new benchmark using `update` as context :

```
./vendor/bin/phpbench run --store --tag="update" --report=default
```

You can then list log to see evolution using : 

```
./vendor/bin/phpbench log
```

Or even better, compare the 2 benchmarks and see if you don't degrade performance with your changes :

```
./vendor/bin/phpbench run --report=aggregate --ref=initial
```
