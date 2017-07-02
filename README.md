# Readme
[![License: MIT](https://img.shields.io/badge/License-MIT-blue.svg)](https://opensource.org/licenses/MIT) 
[![Build Status](https://travis-ci.org/Samffy/recurrence.svg?branch=master)](https://travis-ci.org/Samffy/recurrence)
[![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/Samffy/recurrence/badges/quality-score.png?b=master)](https://scrutinizer-ci.com/g/Samffy/recurrence/?branch=master)
[![Code Coverage](https://scrutinizer-ci.com/g/Samffy/recurrence/badges/coverage.png?b=master)](https://scrutinizer-ci.com/g/Samffy/recurrence/?branch=master)

## Presentation

**WARNING** : This is a work in progress.

This library is a simple test to check optimization possibilities on recurrence calculation. 

RFC : https://tools.ietf.org/html/rfc5545#page-37

## Usage

### Create recurrences using object method

```php
$recurrence = (new Recurrence())
    ->setFrequency(new Frequency('MONTHLY')
    ->setPeriodStartAt(new \Datetime('2017-01-01'))
    ->setPeriodEndAt(new \Datetime('2017-12-31'))
    ->setInterval(1);
$periods    = (new DatetimeProvider($recurrence))-provide();
```

Available methods :
- `setFrequency` (`Frequency`) : set `FREQ` option
- `setPeriodStartAt` (`\Datetime()`) : set `DTSTART` option
- `setPeriodEndAt` (`\Datetime()`) : set `UNTIL` option
- `setInterval` (`integer`) : set `INTERVAL` option
- `setCount` (`integer`) : set `COUNT` option

### Create recurrences from RRULE standard expression

This example as the same result as example above using object method :

```php
$recurrence = (new RecurrenceProvider())->parse('FREQ=MONTHLY;DTSTART=20170101;UNTIL=20171231;INTERVAL=1');
$periods    = (new DatetimeProvider())-provide($recurrence);
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

### Unit tests

```
./vendor/bin/atoum -d tests/units/Recurrence
```

Html code coverage is generated here : `./var/code-coverage`

Remember that you need `xdebug` to generate code coverage report.

### Benchmark

To assume that you don't degrade performance when you update the library, run a benchmark using context name `initial` first :

```
./vendor/bin/phpbench run --store --context="initial" --dump-file=var/benchmark/initial.xml
```

Use `--report=default` option if you want to see report in console.

Before committing your changes, run a new benchmark using `update` as context :

```
./vendor/bin/phpbench run --store --context="update" --dump-file=var/benchmark/update.xml
```

You can then list log to see evolution using : 

```
./vendor/bin/phpbench log
```

Or even better, compare the 2 benchmarks and see if you don't degrade performance with your changes :

```
./vendor/bin/phpbench report --file=var/benchmark/initial.xml --file=var/benchmark/update.xml --report=compare
```


