<?php

declare(strict_types=1);

namespace App;

use App\AnalysisResults\ConversationAnalysisResult;
use App\ChannelDataProviders\ChannelDataProviderInterface;
use App\Conversation\ConversationResultBuilder;
use App\SilenceReversers\SilenceToMonologueReverserInterface;

readonly class Application
{
    public function __construct(
        private ChannelDataProviderInterface $userChannelDataProvider,
        private ChannelDataProviderInterface $customerChannelDataProvider,
        private SilenceToMonologueReverserInterface $silenceToMonologueReverser,
        private ConversationResultBuilder $conversationResultBuilder
    ) {}

    public function run(): ConversationAnalysisResult
    {
        $userMonologue = $this->silenceToMonologueReverser->reverseSilenceContentToMonologue($this->userChannelDataProvider->getData());
        $customerMonologue = $this->silenceToMonologueReverser->reverseSilenceContentToMonologue($this->customerChannelDataProvider->getData());

        return $this->conversationResultBuilder->build($userMonologue, $customerMonologue);
    }
}
