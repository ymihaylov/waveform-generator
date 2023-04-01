<?php

namespace App;

use App\AnalysisResults\ConversationAnalysisResult;
use App\ChannelDataProviders\ChannelDataProviderInterface;
use App\Conversation\ConversationResultBuilder;
use App\SilenceReversers\SilenceToMonologueReverserInterface;

class Application
{
    public function __construct(
        private readonly ChannelDataProviderInterface $userChannelDataProvider,
        private readonly ChannelDataProviderInterface $customerChannelDataProvider,
        private readonly SilenceToMonologueReverserInterface $silenceToMonologueReverser,
        private readonly ConversationResultBuilder $conversationResultBuilder
    ) {}

    public function run(): ConversationAnalysisResult
    {
        $userMonologue = $this->silenceToMonologueReverser->reverseSilenceContentToMonologue($this->userChannelDataProvider->getData());
        $customerMonologue = $this->silenceToMonologueReverser->reverseSilenceContentToMonologue($this->customerChannelDataProvider->getData());

        return $this->conversationResultBuilder->build($userMonologue, $customerMonologue);
    }
}
