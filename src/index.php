<?php
declare(strict_types=1);

require_once __DIR__ . '/../vendor/autoload.php';

$silenceFileParser = new \App\FfmpegFormatSilenceReverser();
$percentageCalculator = new \App\PercentageCalculator();

$userChannelFile = '../resources/user-channel.txt';
$customerChannelFile = '../resources/customer-channel.txt';

$userFileHandler = new \App\FileHandler($userChannelFile);
$userChannelContent = $userFileHandler->getFileContent($userChannelFile);

$customerFileHandler = new \App\FileHandler($customerChannelFile);
$customerChannelContent = $customerFileHandler->getFileContent($customerChannelFile);

$analyzer = new \App\ConversationAnalyzer($silenceFileParser, $percentageCalculator);
$result = $analyzer->analyze($userChannelContent, $customerChannelContent);

header('Content-Type: application/json');

// Convert the array to a JSON string and echo it
echo json_encode($result);
