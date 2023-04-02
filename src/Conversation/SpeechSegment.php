<?php
declare(strict_types=1);

namespace App\Conversation;

readonly class SpeechSegment
{
    /**
     * @param float $startTalkingAt
     * @param float $endTalkingAt
     */
    public function __construct(
        private float $startTalkingAt,
        private float $endTalkingAt
    ) {

        if ($startTalkingAt >= $endTalkingAt) {
            throw new \InvalidArgumentException('The $startTalkingAt value must be smaller than the $endTalkingAt value.');
        }
    }

    public function getDuration(): float
    {
        return round($this->endTalkingAt - $this->startTalkingAt, 3);
    }

    /**
     * @return array
     */
    public function toArray(): array
    {
        return [$this->startTalkingAt, $this->endTalkingAt];
    }
}
