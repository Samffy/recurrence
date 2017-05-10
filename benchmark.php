<?php

define('ITERATION', 40);
define('INCREMENT', 1);

require 'vendor/autoload.php';
require 'src/Benchmark.php';

// Init statistics values
$statistics = [];
$statistics['recurr']['time']     = 0;
$statistics['php']['time']        = 0;
$statistics['recurrence']['time'] = 0;

$benchmark = new Benchmark();

$iteration = 1;
$years     = 1;
while($iteration <= ITERATION) {
    echo '.';
    // Init new period with new interval in years
    $start = new \Datetime(sprintf('%s-%s-01', rand(1000, 9999), rand(1, 12)));
    $end   = clone $start;
    $end->modify(sprintf('+%s year', $years));

    $statistics['recurr']['time']     += $benchmark->launchRecurrGeneration($start, $end);
    $statistics['recurrence']['time'] += $benchmark->launchRecurrenceGeneration($start, $end);
    $statistics['php']['time']        += $benchmark->launchNativePhpGeneration($start, $end);

    $years += INCREMENT;
    $iteration++;
}

echo "\n\n";

echo "# Parameters\n";

echo sprintf(" Iterations: %s\n", ITERATION);
echo sprintf(" Increment testing period from [1] to [%s] years by step of [%s]\n", INCREMENT*ITERATION, INCREMENT);

echo "\n";

echo "# Average time\n";

echo sprintf(" PHP native : %s\n", round($statistics['php']['time']/ITERATION, 10));
echo sprintf(" Recurr : %s\n", round($statistics['recurr']['time']/ITERATION, 10));
echo sprintf(" Recurrence : %s\n", round($statistics['recurrence']['time']/ITERATION, 10));

echo "\n";

echo "# Compare\n";

echo sprintf(" PHP native is x%s faster than Recurr\n", round($statistics['recurr']['time']/$statistics['php']['time'], 2));
echo sprintf(" Recurrence is x%s faster than Recurr\n", round($statistics['recurr']['time']/$statistics['recurrence']['time'], 2));

echo "\n";
