<?php
$start = microtime(true);
$input = file_get_contents('input.txt');
//$input = file_get_contents('input_test.txt');
$units = array_unique(str_split(strtolower($input)));
sort($units);
echo "Finished extracting units\n";

/**
 * https://stackoverflow.com/questions/1252693/using-str-replace-so-that-it-only-acts-on-the-first-match/1252710#1252710
 *
 * @param $haystack
 * @param $needle
 * @return mixed
 */
function replace($haystack, $needle) {
    $pos = strpos($haystack, $needle);
    if ($pos !== false) {
        return substr_replace($haystack, '', $pos, strlen($needle));
    }
}

$reactions = [];
foreach (range('a', 'z') as $char) {
    $reactions[] = $char.strtoupper($char);
    $reactions[] = strtoupper($char).$char;
}

foreach ($units as $unit) {
    $polymer = str_replace([$unit, strtoupper($unit)], '', $input);
//    echo "Removing " . strtoupper($unit) . "/{$unit} units produces {$polymer}. ";

    do {
        $found = false;
        for ($i = 0; $i < strlen($polymer) - 1; $i++) {
            $char = $polymer[$i];
            // credit goes to https://stackoverflow.com/a/6612519/434954 for figuring out how to flip case on a character
            $inverse = strtolower($char) ^ strtoupper($char) ^ $char;

            $reaction = $char.$inverse;

            if ($polymer[$i + 1] === $inverse && in_array($reaction, $reactions)) {
                $polymer = replace($polymer, $char.$inverse);
                $found = true;
            }
        }
    } while ($found);

//    echo "Fully reacting this polymer produces {$polymer}, has has a length of " . strlen($polymer) . PHP_EOL;

    $reaction_results[$unit] = strlen($polymer);
    echo "Reaction results for {$unit}: " . strlen($polymer) . PHP_EOL;
}

echo min($reaction_results) . PHP_EOL;
echo "That took " . (microtime(true) - $start) . " seconds.\n";