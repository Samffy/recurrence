<?php

$statistics = [];

require 'vendor/autoload.php';

$start = new \Datetime(sprintf('%s-%s-01', rand(1000, 9999), rand(1, 12)));
$end   = clone $start;
$end->modify('+4 year'); // When you adding greater period, PHP native superiority is less important

echo sprintf("Period : %s to %s\n\n", $start->format('c'), $end->format('c'));

//----------------------------------
// Recurr library

$startAt = microtime(true);

$rule = (new \Recurr\Rule)
    ->setStartDate($start)
    ->setUntil($end)
    ->setFreq('MONTHLY')
;
$transformer = new \Recurr\Transformer\ArrayTransformer();
$recurrences = $transformer->transform($rule);

foreach ($recurrences as $recurrence) {
    $recurrence->getStart()->format('c')."\n";
}

$statistics['recurr']['time'] = microtime(true) - $startAt;

//----------------------------------
// PHP native

$startAt = microtime(true);

$interval = new \DateInterval('P1M');
$period = new \DatePeriod($start, $interval, $end);

// Need to process results, without that, PHP native is too damn fast ! Seems results are generated when accessing data
foreach ($period as $date) {
    $date->format('c')."\n";
}

$statistics['php']['time'] = microtime(true) - $startAt;

//----------------------------------
// New recurrence library

$startAt = microtime(true);

$recurrence = (new \Recurrence\Recurrence())
    ->setPeriodStartAt($start)
    ->setPeriodEndAt($end)
    ->setFrequency(new \Recurrence\Frequency(\Recurrence\Frequency::FREQUENCY_MONTHLY))
;
$period = (new \Recurrence\DatetimeProvider($recurrence))->provide();

foreach ($period as $date) {
    $date->format('c')."\n";
}

$statistics['recurrence']['time'] = microtime(true) - $startAt;

//----------------------------------

echo "# Time\n";

echo sprintf(" PHP native : %s\n", round($statistics['php']['time'], 10));
echo sprintf(" Recurr : %s\n", round($statistics['recurr']['time'], 10));
echo sprintf(" Recurrence : %s\n", round($statistics['recurrence']['time'], 10));

echo "\n";

echo "# Compare\n";

echo sprintf(" PHP native is x%s faster than Recurr\n", round($statistics['recurr']['time']/$statistics['php']['time'], 2));
echo sprintf(" Recurrence is x%s faster than Recurr\n", round($statistics['recurr']['time']/$statistics['recurrence']['time'], 2));