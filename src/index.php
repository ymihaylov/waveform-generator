<?php
declare(strict_types=1);

require_once __DIR__ . '/../vendor/autoload.php';

// TODO: to config
$userChannelFile = '../resources/user-channel.txt';
$customerChannelFile = '../resources/customer-channel.txt';


$userFileHandler = new \App\Utils\FileHandler($userChannelFile);
$userChannelDataProvider = new \App\ChannelDataProviders\FileChannelDataProvider($userFileHandler);

$customerFileHandler = new \App\Utils\FileHandler($customerChannelFile);
$customerChannelDataProvider = new \App\ChannelDataProviders\FileChannelDataProvider($customerFileHandler);

$conversationRawData = new \App\Conversation\ChannelsRawData($userChannelDataProvider, $customerChannelDataProvider);

$silenceFileParser = new \App\SilenceReversers\FfmpegFormatSilenceReverser();
$analyzer = new \App\Conversation\ConversationAnalyzer($silenceFileParser);
$conversationAnalysisResult = $analyzer->analyze($conversationRawData);

header('Content-Type: application/json');

// Convert the array to a JSON string and echo it
echo json_encode($conversationAnalysisResult->toArray());
