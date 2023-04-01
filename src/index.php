<?php
declare(strict_types=1);

require_once __DIR__ . '/../vendor/autoload.php';

// - Something which is working with files - file manager?
// - Something which knows how to extract silence start and silence_end
// - ResponseClass
// - Monolog class
// - MonologEntry class
// - Error handling

function calculateLongestMonologue(array $monologData): float {
    $longestMonolog = 0;

    foreach ($monologData as $monologEntry) {
        $current = round($monologEntry[1] - $monologEntry[0], 3);

        if ($current > $longestMonolog) {
            $longestMonolog = $current;
        }
    }

    return $longestMonolog;
}
function calculateTotalMonologue(array $monologData): float {
    return array_reduce($monologData, function ($carry, $item) {
        return round($carry + ($item[1] - $item[0]), 3);
    }, 0);
}
function calculateTalkPercentage($userTotalMonolog, $customerTotalMonolog) {
    $totalTalkTime = $userTotalMonolog + $customerTotalMonolog;

    if ($totalTalkTime == 0) {
        return 0;
    }

    $talkPercentage = ($userTotalMonolog / $totalTalkTime) * 100;

    return round($talkPercentage, 2);
}

$silenceFileParser = new \App\SilenceFileParser();

// User data and manipulation
$userChannelFile = '../resources/user-channel.txt';
$userMonologData = $silenceFileParser->reverseSilenceFileToMonologueArray($userChannelFile)->toArray();
$userLongestMonolog = calculateLongestMonologue($userMonologData);
$userTotalMonolog = calculateTotalMonologue($userMonologData);

// Customer data and manipulation
$customerChannelFile = '../resources/customer-channel.txt';
$customerMonologData = $silenceFileParser->reverseSilenceFileToMonologueArray($customerChannelFile)->toArray();
$customerLongestMonolog = calculateLongestMonologue($customerMonologData);
$customerTotalMonolog = calculateTotalMonologue($customerMonologData);

$userTalkPercentage = calculateTalkPercentage($userTotalMonolog, $customerTotalMonolog);

header('Content-Type: application/json');

// Convert the array to a JSON string and echo it
echo json_encode([
    'longest_user_monologue' => $userLongestMonolog,
    'longest_customer_monologue' => $customerLongestMonolog,
    'user_talk_percentage' => $userTalkPercentage,
    "user" => $userMonologData,
    "customer" => $customerMonologData,
]);
