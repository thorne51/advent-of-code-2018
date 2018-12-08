<?php
/**
 * @see https://github.com/jmcastagnetto/Math_Distance/blob/master/src/Math/Distance/Manhattan.php
 *
 * @param $vector1
 * @param $vector2
 * @return float|int
 */
function manhattan_distance($vector1, $vector2)
{
    $n = count($vector1);
    $sum = 0;
    for ($i = 0; $i < $n; $i++) {
        $sum += abs($vector1[$i] - $vector2[$i]);
    }
    return $sum;
}
