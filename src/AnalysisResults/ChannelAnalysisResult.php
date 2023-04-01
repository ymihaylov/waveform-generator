<?php
declare(strict_types=1);

namespace App\AnalysisResults;

use App\Conversation\Monologue;

readonly class ChannelAnalysisResult
{
    private float $longestSpeechSegmentDuration;
    private float $totalSpeechDuration;
    private array $channelData;

    /**
     * @param Monologue $monologue
     */
    public function __construct(Monologue $monologue) {
        $this->longestSpeechSegmentDuration = $monologue->getLongestSpeechSegment()->getDuration();
        $this->totalSpeechDuration = $monologue->getTotalDuration();
        $this->channelData = $monologue->toArray();
    }

    /**
     * @return float
     */
    public function getLongestSpeechSegmentDuration(): float
    {
        return $this->longestSpeechSegmentDuration;
    }

    /**
     * @return float
     */
    public function getTotalSpeechDuration(): float
    {
        return $this->totalSpeechDuration;
    }

    /**
     * @return array
     */
    public function getChannelData(): array
    {
        return $this->channelData;
    }
}
