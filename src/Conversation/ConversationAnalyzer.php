<?php
declare(strict_types=1);

namespace App\Conversation;

use App\AnalysisResults\ChannelAnalysisResult;
use App\AnalysisResults\ConversationAnalysisResult;
use App\SilenceReversers\SilenceToMonologueReverserInterface;

class ConversationAnalyzer
{
    public function __construct(
        readonly private SilenceToMonologueReverserInterface $silenceReverser
    ) {}

    /**
     * @param string $userChannelContent
     * @param string $customerChannelContent
     * @return ConversationAnalysisResult
     */
    public function analyze(ChannelsRawData $channelsRawData): ConversationAnalysisResult
    {
        $userChannelData = $channelsRawData->getUserChannelRawData();
        $customerChannelData = $channelsRawData->getCustomerChannelRawData();

        // === USER
        $userChannelAnalyzedData = $this->analyzeChannel($userChannelData); // TODO: catch exception

        // === CUSTOMER
        $customerChannelAnalyzedData = $this->analyzeChannel($customerChannelData); // TODO: catch exception

        // === CONVERSATION
        return new ConversationAnalysisResult($userChannelAnalyzedData, $customerChannelAnalyzedData);
    }

    private function analyzeChannel(string $channelContent): ChannelAnalysisResult
    {
        $monologue = $this->silenceReverser->reverseSilenceContentToMonologue($channelContent); // TODO: catch exception

        return new ChannelAnalysisResult($monologue);
    }
}
