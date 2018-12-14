<?php
$start = microtime(true);
$input = explode("\n", file_get_contents('input.txt'));
//$input = explode("\n", file_get_contents('input_test.txt'));

$sheets = [];
foreach ($input as $row) {
    if (empty($row)) { continue; }

    $parts = explode(' @ ', $row);

    $id = substr($parts[0], 1);
    $position = explode(',', substr($parts[1], 0, strpos($parts[1], ':')));
    $size = explode('x', substr($parts[1], strpos($parts[1], ': ') + 2));

    $sheets[$id] = [
        'id' => $id,
        'position' => ['left' => $position[0], 'top' => $position[1]],
        'size' => ['w' => $size[0], 'h' => $size[1]],
    ];
}

$fabric = array_fill(0, 1000, array_fill(0, 1000, '.'));

foreach ($sheets as $id => $sheet) {
    $x = $sheet['position']['left'];
    $y = $sheet['position']['top'];
    $w = $sheet['size']['w'];
    $h = $sheet['size']['h'];

    for ($i = $x; $i < $x + $w; $i++) {
        for ($j = $y; $j < $y + $h; $j++) {
            if ('.' === $fabric[$j][$i]) {
                $fabric[$j][$i] = $sheet['id'];
            } else {
                $fabric[$j][$i] = 'x';
            }
        }
    }
}

foreach ($sheets as $id => $sheet) {
    $x = $sheet['position']['left'];
    $y = $sheet['position']['top'];
    $w = $sheet['size']['w'];
    $h = $sheet['size']['h'];

    $hasOverlap = false;

    for ($i = $x; $i < $x + $w; $i++) {
        for ($j = $y; $j < $y + $h; $j++) {
            if ('x' === $fabric[$j][$i]) {
                $hasOverlap = true;
                break 2;
            }
        }
    }

    if (!$hasOverlap) {
        var_dump($id);
        break;
    }
}
echo "That took " . (microtime(true) - $start) . " seconds.";