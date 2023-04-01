<?php
declare(strict_types=1);

namespace App;

class SpeechSegment
{
    /**
     * @param float $startTalkingAt
     * @param float $endTalkingAt
     */
    public function __construct(
        private float $startTalkingAt,
        private float $endTalkingAt
    ) {}

    public function getDuration(): float
    {
        return $this->endTalkingAt - $this->startTalkingAt;
    }

    /**
     * @return float
     */
    public function getStartTalkingAt(): float
    {
        return $this->startTalkingAt;
    }

    /**
     * @param float $startTalkingAt
     * @return SpeechSegment
     */
    public function setStartTalkingAt(float $startTalkingAt): SpeechSegment
    {
        $this->startTalkingAt = $startTalkingAt;
        return $this;
    }

    /**
     * @return float
     */
    public function getEndTalkingAt(): float
    {
        return $this->endTalkingAt;
    }

    /**
     * @param float $endTalkingAt
     * @return SpeechSegment
     */
    public function setEndTalkingAt(float $endTalkingAt): SpeechSegment
    {
        $this->endTalkingAt = $endTalkingAt;
        return $this;
    }

    /**
     * @return array
     */
    public function toArray(): array
    {
        return [$this->getStartTalkingAt(), $this->getEndTalkingAt()];
    }
}