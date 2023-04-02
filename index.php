<?php
declare(strict_types=1);

require_once __DIR__ . '/vendor/autoload.php';

$config = require __DIR__ . '/config.php';

$userChannelFile = $config['user_channel_file'];
$customerChannelFile = $config['customer_channel_file'];

$userFileHandler = new \App\Utils\FileContentReader($userChannelFile);
$customerFileHandler = new \App\Utils\FileContentReader($customerChannelFile);

$application = new \App\Application(
    new \App\ChannelDataProviders\FileChannelDataProvider($userFileHandler),
    new \App\ChannelDataProviders\FileChannelDataProvider($customerFileHandler),
    new \App\SilenceReversers\FfmpegFormatSilenceReverser(),
    new \App\Conversation\ConversationResultBuilder(),
);

$conversationAnalysisResult = $application->run();

header('Content-Type: application/json');

// Convert the array to a JSON string and echo it
echo json_encode($conversationAnalysisResult->toArray());
