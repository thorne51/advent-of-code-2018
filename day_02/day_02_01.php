<?php
$input = file('input.txt', FILE_IGNORE_NEW_LINES);

$twoTimes = 0;
$threeTimes = 0;

foreach ($input as $row) {
    $chars = array_unique(str_split($row));

    $hasTwo = false;
    $hasThree = false;

    foreach ($chars as $char) {
        $cnt = substr_count($row, $char);
        if ($cnt === 2) { $hasTwo = true; }
        if ($cnt === 3) { $hasThree = true; };
    }

    if ($hasTwo) { $twoTimes++; }
    if ($hasThree) { $threeTimes++; }
}

echo "Checksum is: {$twoTimes} * {$threeTimes} = " . ($twoTimes * $threeTimes) . "\n";