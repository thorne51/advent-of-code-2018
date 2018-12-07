<?php
$start = microtime(true);
$input = file_get_contents('input.txt');
//$input = file_get_contents('input_test.txt');

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
    var_dump($haystack, $needle);
    die('oh nohs');
}

$reactions = [];
foreach (range('a', 'z') as $char) {
    $reactions[] = $char.strtoupper($char);
    $reactions[] = strtoupper($char).$char;
}

$polymer = $input;
do {
    $found = false;
    for ($i = 0; $i < strlen($polymer) - 1; $i++) {
        $char = $polymer[$i];
        // credit goes to https://stackoverflow.com/a/6612519/434954 for figuring out how to flip case on a character
        $inverse = strtolower($char) ^ strtoupper($char) ^ $char;

        if ($polymer[$i + 1] === $inverse && in_array($char.$inverse, $reactions)) {
            $polymer = replace($polymer, $char.$inverse);
            $found = true;
        }
    }
} while ($found);

echo strlen($polymer) . PHP_EOL;
echo "That took " . (microtime(true) - $start) . " seconds.\n";