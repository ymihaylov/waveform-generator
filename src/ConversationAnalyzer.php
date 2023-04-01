<?php
declare(strict_types=1);

namespace App;

class ConversationAnalyzer
{
    public function __construct(
        readonly private SilenceToMonologueReverserInterface $silenceReverser,
        readonly private PercentageCalculator $percentageCalculator
    ) {}

    /**
     * @param string $userChannelContent
     * @param string $customerChannelContent
     * @return array
     */
    public function analyze(string $userChannelContent, string $customerChannelContent): array
    {
        // === USER
        $userChannelAnalyzedData = $this->analyzeChannel($userChannelContent); // TODO: catch exception

        // === CUSTOMER
        $customerChannelAnalyzedData = $this->analyzeChannel($customerChannelContent); // TODO: catch exception

        return [
            'longest_user_monologue' => $userChannelAnalyzedData->getLongestSpeechSegmentDuration(),
            'longest_customer_monologue' => $customerChannelAnalyzedData->getLongestSpeechSegmentDuration(),
            'user_talk_percentage' => $userChannelAnalyzedData->calculateSpeechPercentage($customerChannelAnalyzedData),
            "user" => $userChannelAnalyzedData->getChannelData(),
            "customer" => $customerChannelAnalyzedData->getChannelData(),
        ];
    }

    private function analyzeChannel(string $channelContent): ChannelAnalysisResult
    {
        $monologue = $this->silenceReverser->reverseSilenceContentToMonologue($channelContent); // TODO: catch exception

        return new ChannelAnalysisResult($monologue);
    }
}
