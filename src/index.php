<?php
declare(strict_types=1);

require_once __DIR__ . '/../vendor/autoload.php';

$customerChannelFile = '../resources/customer-channel.txt';

// Check if it's opened correctly.
$handle = fopen($customerChannelFile, 'r');
$content = '';

$result = [];

$silenceStartAt = 0;
$previousEndSilence = 0;

if ($handle) {
    while (($line = fgets($handle)) !== false) {
        if (str_contains($line, 'silence_start') !== false) {
            // Process the silence_start line
            preg_match('/silence_start:\s*([\d.]+)/', $line, $matches);
            $silenceStartAt = $matches[1];
        } elseif (str_contains($line, 'silence_end')) {
            preg_match('/silence_end:\s*([\d.]+)/', $line, $matches);
            $silenceEndAt = $matches[1];

            $result[] = [$previousEndSilence, $silenceStartAt];
            $previousEndSilence = $silenceEndAt;
        } else {
            // This line doesn't contain either 'silence_start' or 'silence_end'
            echo "Unknown line: " . $line;
        }
    }

    fclose($handle);
} else {
    echo "Error opening the file";
}

echo '<pre>';
var_dump($result);

$userChannelFile = '../resources/user-channel.txt';
