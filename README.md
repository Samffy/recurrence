# Readme
[![License: MIT](https://img.shields.io/badge/License-MIT-blue.svg)](https://opensource.org/licenses/MIT) 
[![Build Status](https://travis-ci.org/Samffy/recurrence.svg?branch=master)](https://travis-ci.org/Samffy/recurrence)
[![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/Samffy/recurrence/badges/quality-score.png?b=master)](https://scrutinizer-ci.com/g/Samffy/recurrence/?branch=master)

## Presentation

**WARNING** : This is a work in progress.

This library is a simple test to check optimization possibilities on recurrence calculation. 

RFC : https://tools.ietf.org/html/rfc5545#page-37

## Usage

### Create recurrences using object method

```php
$recurrence = (new Recurrence())
->setPeriodStartAt(new \Datetime())
->setFrequency(new Frequency('MONTHLY');
$periods    = (new DatetimeProvider($recurrence))-provide();
```

### Create recurrences from RRULE standard expression

```php
$recurrence = Recurrence::createRecurrenceFromRrule('FREQ=MONTHLY;BYMONTHDAY=1;INTERVAL=2');
$periods    = (new DatetimeProvider($recurrence))-provide();
```

### Unit tests

```
./vendor/bin/atoum -d tests/units/Recurrence
```

Html code coverage is generated here : `./var/code-coverage`

Remember that you need `xdebug` to generate code coverage report.

### First findings

* PHP native is extremely fast if we do not process results
* Greater is the period of computation, less important is the predominance of PHP native
* First I try a static Frequency class, with static methods, it's seem slower (about 2s slower on a 4month period)
* I try to launch many process on different periods to smooth results
