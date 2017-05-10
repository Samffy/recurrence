# Readme

**WARNING** : This is a work in progress.

This library is a simple test to check optimization possibilities on recurrence calculation. 

RFC : https://tools.ietf.org/html/rfc5545#page-37

#### Unit tests

```
./vendor/bin/atoum -d tests/units/Recurrence
```

Html code coverage is generated here : `./var/code-coverage`

Remember that you need `xdebug` to generage code coverage report.

#### First findings

* PHP native is extremely fast if we do not process results
* Greater is the period of computation, less important is the predominance of PHP native
* First I try a static Frequency class, with static methods, it's seem slower (about 2s slower on a 4month period)
* I try to launch many process on different periods to smooth results
