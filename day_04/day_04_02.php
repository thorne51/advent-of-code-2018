<?php
$input = file_get_contents('input.txt');
//$input = file_get_contents('input_test.txt');

$logs = array_filter(explode("\n", $input));
sort($logs);

$guards = [];
$currentGuard = null;
$state = null;
$currentMinutes = 0;
foreach ($logs as $row) {
    echo "{$row}\n";

    preg_match('/(?<=\[).*(?=\])/', $row, $matches);
    $time = strtotime($matches[0]);
    $minutes = intval(date('i', $time));

    preg_match('/(?<=\] ).*/', $row, $matches);
    $entry = $matches[0];

    switch ($entry) {
        case strpos($entry, 'Guard') !== false:
            preg_match('/(?<=\#)\d*/', $row, $matches);
            $currentGuard = $matches[0];
            $state = 'awake';

            if (empty($guards[$currentGuard])) {
                $guards[$currentGuard] = array_fill(0, 60, 0);
            }

            break;

        case 'wakes up':
            $state = 'awake';
            for ($i = $currentMinutes; $i < $minutes; $i++) {
                $guards[$currentGuard][$i]++;
            }
            break;

        case 'falls asleep':
            $state = 'asleep';
            $currentMinutes = $minutes;
            break;
    }
}

$mostFrequentMinute = 0;
$frequency = 0;
$guard = null;
foreach ($guards as $guardId => $minutes) {
    $minute = array_search(max($minutes), $minutes);
    $times = $minutes[$minute];

    echo "#{$guardId} slept {$times} times during minute {$minute}\n";

    if ($times > $frequency) {
        $frequency = $times;
        $guard = $guardId;
        $mostFrequentMinute = $minute;
    }
}

echo "#{$guard} most frequently slept at minute {$mostFrequentMinute} ({$frequency} times): {$guard} * {$mostFrequentMinute} = " . ($guard * $mostFrequentMinute) . "\n";