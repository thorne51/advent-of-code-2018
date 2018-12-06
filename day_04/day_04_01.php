<?php
$input = file_get_contents('input.txt');
//$input = file_get_contents('input_test.txt');

$logs = [];
$rows = array_filter(explode("\n", $input));
foreach ($rows as $row) {
    preg_match('/(?<=\[).*(?=\])/', $row, $matches);
    $time = strtotime($matches[0]);
    $logs[$time] = $row;
}
ksort($logs);

$guards = [];
$currentGuard = null;
$state = null;
foreach ($logs as $time => $row) {
    preg_match('/(?<=\[).*(?=\])/', $row, $matches);
    $datetime = $matches[0];

    preg_match('/(?<=:).*(?=\])/', $row, $matches);
    $minutes = $matches[0];

    preg_match('/(?<=\] ).*/', $row, $matches);
    $entry = $matches[0];

    if (strpos($entry, 'Guard') !== false) {
        preg_match('/(?<=\#)\d*/', $row, $matches);
        $currentGuard = $matches[0];
        $state = 'awake';
    }

    if ('wakes up' === $entry) {
        $state = 'awake';
    }

    if ('falls asleep' === $entry) {
        $state = 'asleep';
    }

//    $guards[$currentGuard][$minutes]
}