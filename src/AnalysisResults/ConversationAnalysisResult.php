<?php
declare(strict_types=1);

namespace App\AnalysisResults;

use App\Utils\PercentageCalculator;

readonly class ConversationAnalysisResult
{
    public function __construct(
        private ChannelAnalysisResult $userChannelAnalysis,
        private ChannelAnalysisResult $customerChannelAnalysis,
    ) {}

    public function toArray(): array
    {
        return [
            'longest_user_monologue' => $this->userChannelAnalysis->getLongestSpeechSegmentDuration(),
            'longest_customer_monologue' => $this->customerChannelAnalysis->getLongestSpeechSegmentDuration(),
            'user_talk_percentage' => PercentageCalculator::calculatePercentageOfTotal(
                $this->userChannelAnalysis->getTotalSpeechDuration(),
                $this->customerChannelAnalysis->getTotalSpeechDuration(),
            ),
            "user" => $this->userChannelAnalysis->getChannelData(),
            "customer" => $this->customerChannelAnalysis->getChannelData(),
        ];
    }
}