<?php
declare(strict_types=1);

namespace App;

class Monologue
{
    /**
     * @param SpeechSegment[] $speechSegments
     */
    public function __construct(
        public array $speechSegments = [],
    ) {}

    public function addSpeechSegment(SpeechSegment $speechSegment): void
    {
        $this->speechSegments[] = $speechSegment;
    }

    /**
     * @return SpeechSegment[]
     */
    public function getSpeechSegments(): array
    {
        return $this->speechSegments;
    }

    public function toArray(): array
    {
        return array_map(function (SpeechSegment $speechSegment) {
            return $speechSegment->toArray();
        }, $this->getSpeechSegments());
    }
}
