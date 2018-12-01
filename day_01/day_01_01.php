<?php
$input = fopen('input.txt', 'r');
$frequency = 0;
while (($row = fgets($input)) !== false) {
	$operation = substr($row, 0, 1);
	$amount = intval(substr($row, 1));
	switch ($operation) {
		case '+':
			$frequency += $amount;
			break;

		case '-':
			$frequency -= $amount;
			break;
	}
}
echo "Resulting frequency: " . $frequency;