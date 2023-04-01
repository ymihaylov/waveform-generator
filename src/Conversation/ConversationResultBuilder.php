<?php
declare(strict_types=1);

namespace App\Conversation;

use App\AnalysisResults\ChannelAnalysisResult;
use App\AnalysisResults\ConversationAnalysisResult;

class ConversationResultBuilder
{
    /**
     * @param Monologue $userMonologue
     * @param Monologue $customerMonologue
     * @return ConversationAnalysisResult
     */
    public function build(Monologue $userMonologue, Monologue $customerMonologue): ConversationAnalysisResult
    {
        // === USER
        $userChannelAnalyzedData = new ChannelAnalysisResult($userMonologue);

        // === CUSTOMER
        $customerChannelAnalyzedData = new ChannelAnalysisResult($customerMonologue);

        // === CONVERSATION
        return new ConversationAnalysisResult($userChannelAnalyzedData, $customerChannelAnalyzedData);
    }
}
