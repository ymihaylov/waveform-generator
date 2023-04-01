<?php
declare(strict_types=1);

require_once __DIR__ . '/../vendor/autoload.php';

// - Something which is working with files - file manager?
// - Something which knows how to extract silence start and silence_end
// - ResponseClass
// - Monolog class
// - MonologEntry class
// - Error handling
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
$userMonologue = $silenceFileParser->reverseSilenceFileToMonologueArray($userChannelFile);
$userMonologData = $userMonologue->toArray();

$userLongestMonologue = $userMonologue->getLongestSpeechSegment()->getDuration(); // TODO: Check is_null
$userTotalMonolog = calculateTotalMonologue($userMonologData);

// Customer data and manipulation
$customerChannelFile = '../resources/customer-channel.txt';
$customerMonologue = $silenceFileParser->reverseSilenceFileToMonologueArray($customerChannelFile);
$customerMonologueData = $customerMonologue->toArray();

$customerLongestMonologue = $customerMonologue->getLongestSpeechSegment()->getDuration(); // TODO: Check is_null
$customerTotalMonolog = calculateTotalMonologue($customerMonologueData);

$userTalkPercentage = calculateTalkPercentage($userTotalMonolog, $customerTotalMonolog);

header('Content-Type: application/json');

// Convert the array to a JSON string and echo it
echo json_encode([
    'longest_user_monologue' => $userLongestMonologue,
    'longest_customer_monologue' => $customerLongestMonologue,
    'user_talk_percentage' => $userTalkPercentage,
    "user" => $userMonologData,
    "customer" => $customerMonologueData,
]);
