# Readme

**WARNING** : This is a work in progress.

This library is a simple test to check otpimization possibilities on recurrence calculation. 


RFC : https://tools.ietf.org/html/rfc5545#page-37

#### First findings

* First benchmark launch (after server restart for example) is not a good moment for Recurr
* PHP native is extremely fast if we do not process results
* Greater is the period of computation, less important is the predominance of PHP native
* First I try a static Frequency class, with static methods, it's seem slower (about 2s slower on a 4month period)
