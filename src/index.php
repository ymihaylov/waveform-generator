<?php
declare(strict_types=1);

require_once __DIR__ . '/../vendor/autoload.php';

// - Something which is working with files - file manager?
// - Something which knows how to extract silence start and silence_end
// - ResponseClass
// - Monolog class
// - MonologEntry class
// - Error handling

$silenceFileParser = new \App\FfmpegFormatSilenceReverser();

// User data and manipulation
$userChannelFile = '../resources/user-channel.txt';
$userFileHandler = new \App\FileHandler($userChannelFile);
$userChannelFileContent = $userFileHandler->getFileContent($userChannelFile);

$userMonologue = $silenceFileParser->reverseSilenceContentToMonologue($userChannelFileContent); // TODO: catch exception
$userMonologData = $userMonologue->toArray();

$userLongestMonologue = $userMonologue->getLongestSpeechSegment()->getDuration(); // TODO: Check is_null
$userTotalMonolog = $userMonologue->getTotalDuration();

// Customer data and manipulation
$customerChannelFile = '../resources/customer-channel.txt';
$customerFileHandler = new \App\FileHandler($customerChannelFile);
$customerChannelFileContent = $customerFileHandler->getFileContent($customerChannelFile);

$customerMonologue = $silenceFileParser->reverseSilenceContentToMonologue($customerChannelFileContent); // TODO: catch exception
$customerMonologueData = $customerMonologue->toArray();

$customerLongestMonologue = $customerMonologue->getLongestSpeechSegment()->getDuration(); // TODO: Check is_null
$customerTotalMonolog = $customerMonologue->getTotalDuration();

$percentageCalculator = new \App\PercentageCalculator();
$userTalkPercentage = $percentageCalculator->calculatePercentageOfTotal($userTotalMonolog, $customerTotalMonolog);

header('Content-Type: application/json');

// Convert the array to a JSON string and echo it
echo json_encode([
    'longest_user_monologue' => $userLongestMonologue,
    'longest_customer_monologue' => $customerLongestMonologue,
    'user_talk_percentage' => $userTalkPercentage,
    "user" => $userMonologData,
    "customer" => $customerMonologueData,
]);
