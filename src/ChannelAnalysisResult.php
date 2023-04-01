<?php
declare(strict_types=1);

namespace App;

class ChannelAnalysisResult
{
    private PercentageCalculator $percentageCalculator;

    readonly private float $longestSpeechSegmentDuration;
    readonly private float $totalSpeechDuration;
    readonly private array $channelData;

    /**
     * @param Monologue $monologue
     */
    public function __construct(Monologue $monologue, PercentageCalculator $percentageCalculator) {
        $this->percentageCalculator = $percentageCalculator;

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

    /**
     * @param ChannelAnalysisResult $otherChannel
     * @return float
     */
    public function calculateSpeechPercentage(ChannelAnalysisResult $otherChannel): float
    {
        return $this->percentageCalculator->calculatePercentageOfTotal(
            $this->getTotalSpeechDuration(), $otherChannel->getTotalSpeechDuration()
        );
    }
}
