<?php

require_once __DIR__ . '/../vendor/autoload.php';

$customerChannelFile = '../resources/customer-channel.txt';

// Check if it's opened correctly.
$handle = fopen($customerChannelFile, 'r');
$content = '';

$i = 0;
$customerTalk = [
    // start talking   // stop talking
    [0,                null]
];

if ($handle) {
    while (($line = fgets($handle)) !== false) {
        if (mb_strpos($line, 'silence_start') !== false) {
            // Process the silence_start line
            preg_match('/silence_start:\s*([\d.]+)/', $line, $matches);
            $silenceStartAt = $matches[1];

            $customerTalk[$i][1] = $silenceStartAt;
        } elseif (strpos($line, 'silence_end') !== false) {
            preg_match('/silence_end:\s*([\d.]+)/', $line, $matches);
            $silenceEndAt = $matches[1];

            $customerTalk[] = [
                $silenceEndAt, null
            ];

            $i++;
        } else {
            // This line doesn't contain either 'silence_start' or 'silence_end'
            echo "Unknown line: " . $line;
        }

        // Process the line
        echo $line . "<br />";
    }

    fclose($handle);
} else {
    echo "Error opening the file";
}

echo '<pre>';
var_dump($customerTalk);

$userChannelFile = '../resources/user-channel.txt';

