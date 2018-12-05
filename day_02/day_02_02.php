<?php
$input = file('input.txt', FILE_IGNORE_NEW_LINES);
$inputCount = count($input);

for ($i = 0; $i < $inputCount; $i++) {
    $comp = str_split($input[$i]);

    for ($j = $i + 1; $j < $inputCount; $j++) {
        $comp2 = str_split($input[$j]);
        $diff = array_diff_assoc($comp, $comp2);

        if (count($diff) === 1) {
            $key = implode('', array_keys($diff));
            unset($comp[$key]);
            echo implode('', $comp) . "\n";
            die;
        }
    }
}
