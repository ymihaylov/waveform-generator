<?php

declare(strict_types=1);

namespace App\Conversation;

class Monologue
{
    /**
     * @param SpeechSegment[] $speechSegments
     */
    public function __construct(
        private array $speechSegments = [],
    ) {}

    /**
     * @param SpeechSegment $speechSegment
     * @return void
     */
    public function addSpeechSegment(SpeechSegment $speechSegment): void
    {
        $this->speechSegments[] = $speechSegment;
    }

    /**
     * @return ?SpeechSegment
     */
    public function getLongestSpeechSegment(): ?SpeechSegment
    {
        $longestSpeechTime = 0;
        $longestSpeechSegment = null;

        foreach ($this->speechSegments as $currentSpeechSegment) {
            if ($currentSpeechSegment->getDuration() >= $longestSpeechTime) {
                $longestSpeechTime = $currentSpeechSegment->getDuration();
                $longestSpeechSegment = $currentSpeechSegment;
            }
        }

        return $longestSpeechSegment;
    }

    /**
     * @return float
     */
    public function getTotalDuration(): float
    {
        return array_reduce($this->speechSegments, function (float $totalDuration, SpeechSegment $speechSegment) {
            return $totalDuration + $speechSegment->getDuration();
        }, 0);
    }

    /**
     * @return array
     */
    public function toArray(): array
    {
        return array_map(function (SpeechSegment $speechSegment) {
            return $speechSegment->toArray();
        }, $this->speechSegments);
    }
}
