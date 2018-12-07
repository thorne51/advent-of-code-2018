<?php
$start = microtime();
$input = file_get_contents('input.txt');
//$input = file_get_contents('input_test.txt');

$chars = str_split($input);

$found = true;
while ($found) {
    $found = false;
    $previousChar = '';
//    echo implode('', $chars);

    foreach ($chars as $i => $char) {
        // credit goes to https://stackoverflow.com/a/6612519/434954 for figuring out how to flip case on a character
        $inverse = strtolower($char) ^ strtoupper($char) ^ $char;

        if (
            '' !== $previousChar &&
            $char !== $previousChar &&
            $previousChar === $inverse
        ) {
//            echo "\t{$previousChar}{$char}\n";
            unset($chars[$i]);
            unset($chars[$i - 1]);
            $found = true;
            break;
        }

        $previousChar = $char;
    }

    $chars = array_values($chars);
}

echo strlen(implode('', $chars)) . "\n";
$end = microtime();
echo "That took " . ($end - $start) . "\n";