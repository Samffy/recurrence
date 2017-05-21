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
$recurrence = (new RecurrenceProvider())->parse('FREQ=MONTHLY;DTSTART=20170521;INTERVAL=2');
$periods    = (new DatetimeProvider($recurrence))-provide();
```

Supported rules : 
- `FREQ` : `YEARLY`, `MONTHLY`, `WEEKLY`, `DAILY`, `HOURLY`, `MINUTELY`, `SECONDLY`
- `DTSTART` : 
    - Simple date : `YYYYMMDD` (example : `20170520`)
    - Datetime : `YYYYMMDDTHHMMSS` (example : `20170520T154720`)
    - Datetime UTC : `YYYYMMDDTHHMMSSZ` (example : `20170520T154720Z`)
- `DTSTART` with `TZID` : `{timezone}:YYYYMMDDTHHMMSS`  (example : `Europe/Paris:20170520T154720`)
- `UNTIL` : 
    - Simple date : `YYYYMMDD` (example : `20170520`)
    - Datetime : `YYYYMMDDTHHMMSS` (example : `20170520T154720`)
    - Datetime UTC : `YYYYMMDDTHHMMSSZ` (example : `20170520T154720Z`)
- `UNTIL` with `TZID` : `{timezone}:YYYYMMDDTHHMMSS`  (example : `Europe/Paris:20170520T154720`)


### Unit tests

```
./vendor/bin/atoum -d tests/units/Recurrence
```

Html code coverage is generated here : `./var/code-coverage`

Remember that you need `xdebug` to generate code coverage report.
