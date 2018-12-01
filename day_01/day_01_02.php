<?php
$input = fopen('input.txt', 'r');
$frequency = 0;
$frequency_history = [];

while (true) {
	$row = fgets($input);
	if (!$row) {
		echo "Rewinding input...\n";
		rewind($input);
		$row = fgets($input);
	}

	$operation = substr($row, 0, 1);
	$amount = intval(substr($row, 1));

	echo "Frequency: {$frequency} {$operation} {$amount} = ";
	switch ($operation) {
		case '+':
			$frequency += $amount;
			break;

		case '-':
			$frequency -= $amount;
			break;
	}
	echo $frequency . "\n";

	if (in_array($frequency, $frequency_history)) {
		echo "First repeated frequency: " . $frequency;
		break;
	}

	$frequency_history[] = $frequency;
}
