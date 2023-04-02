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
        $userChannelAnalyzedData = new ChannelAnalysisResult($userMonologue);

        $customerChannelAnalyzedData = new ChannelAnalysisResult($customerMonologue);

        return new ConversationAnalysisResult($userChannelAnalyzedData, $customerChannelAnalyzedData);
    }
}
