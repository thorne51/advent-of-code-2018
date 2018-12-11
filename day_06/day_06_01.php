<?php
require_once 'func.inc.php';
$input = file_get_contents('input.txt');
//$input = file_get_contents('input_test.txt');

$rows = explode("\n", $input);

$coordinates = [];
$maxX = 0;
$maxY = 0;
foreach ($rows as $i => $row) {
    echo $row . PHP_EOL;
    $xy = explode(', ', $row);
    $x = intval($xy[0]);
    $y = intval($xy[1]);

    $coordinates[$i] = ['x' => $x, 'y' => $y, 'infinite' => false];

    if ($x > $maxX) { $maxX = $x + 1; }
    if ($y > $maxY) { $maxY = $y + 1; }
}

//var_dump($maxX, $maxY);

$grid = array_fill(0, $maxY, array_fill(0, $maxX, '.'));

// plot coordinates
foreach ($coordinates as $id => $coordinate) {
    $x = $coordinate['x'];
    $y = $coordinate['y'];
    
    $grid[$y][$x] = $id;
}

print_grid($grid);

foreach ($grid as $y => $rows) {
    foreach ($rows as $x => &$point) {
        // skip if not marked
        if ($point !== '.') {
            continue;
        }

        $closestCoordinate = [];
        $closestDistance = null;

        foreach ($coordinates as $id => $coordinate) {
            if ($coordinate['x'] === $x && $coordinate['y'] === $y) {
                continue;
            }

            $distance = manhattan_distance([$x, $y], [$coordinate['x'], $coordinate['y']]);

            if ($closestDistance === null) {
                $closestDistance = $distance;
                $closestCoordinate[] = $id;
                continue;
            }

            if ($distance === $closestDistance) {
                $closestCoordinate[] = $id;
                continue;
            }

            if ($distance < $closestDistance) {
                $closestDistance = $distance;
                $closestCoordinate = [$id];
            }
        }

        // error check
        if (count($closestCoordinate) === 0) {
            echo "Oops, something went wrong..." . PHP_EOL;
            exit;
        }

        if (count($closestCoordinate) === 1) {
            $grid[$y][$x] = $closestCoordinate[0];
        }
    }
}

print_grid($grid);

$coordinateCount = array_fill_keys(array_keys($coordinates), 0);
foreach ($grid as $y => $rows) {
    foreach ($rows as $x => $point) {
        if ($point === '.') {
            // does not count toward total
            continue;
        }

        $coordinateCount[$point]++;
    }
}

// remove infinite coordinates from $coordinateCount
foreach ($coordinates as $id => $coordinate) {
    $x = $coordinate['x'];
    $y = $coordinate['y'];
    $infinite = true;

    // check north
    if ($infinite) {
        for ($i = $y; $i >= 0; $i--) {
            if ($grid[$i][$x] !== $id) {
                $infinite = false;
                break;
            }
        }
    }

    // check south
    if ($infinite) {
        for ($i = $y; $i <= $maxY; $i++) {
            if ($grid[$i][$x] !== $id) {
                $infinite = false;
                break;
            }
        }
    }

    // check east
    if ($infinite) {
        for ($i = $x; $i <= $maxX; $i++) {
            if ($grid[$y][$i] !== $id) {
                $infinite = false;
                break;
            }
        }
    }

    // check west
    if ($infinite) {
        for ($i = $x; $i >= 0; $i++) {
            if ($grid[$y][$i] !== $id) {
                $infinite = false;
                break;
            }
        }
    }

    if ($infinite) {
        unset($coordinateCount[$id]);
        continue;
    }
}

echo max($coordinateCount) . PHP_EOL;