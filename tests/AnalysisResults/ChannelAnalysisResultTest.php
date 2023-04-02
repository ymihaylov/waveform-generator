<?php

declare(strict_types=1);

use App\AnalysisResults\ChannelAnalysisResult;
use App\Conversation\Monologue;
use App\Conversation\SpeechSegment;
use PHPUnit\Framework\TestCase;

class ChannelAnalysisResultTest extends TestCase
{
    /**
     * @dataProvider monologueDataProvider
     */
    public function testChannelAnalysisResult(Monologue $monologue, float $expectedLongestDuration, float $expectedTotalDuration): void
    {
        // Create a Monologue instance with the provided $speechSegments data


        // Create a ChannelAnalysisResult instance using the Monologue instance
        $channelAnalysisResult = new ChannelAnalysisResult($monologue);

        // Assert that the getter methods return the expected values
        $this->assertSame($expectedLongestDuration, $channelAnalysisResult->getLongestSpeechSegmentDuration());
        $this->assertSame($expectedTotalDuration, $channelAnalysisResult->getTotalSpeechDuration());
        $this->assertSame($monologue->toArray(), $channelAnalysisResult->getChannelData());
    }

    public static function monologueDataProvider(): array
    {
        return [
            'monologue with single speech segment' => [
                new Monologue([
                    new SpeechSegment(0, 15),
                ]),
                15.0,
                15.0,
            ],
            'monologue with multiple speech segments' => [
                new Monologue([
                    new SpeechSegment(0, 5),
                    new SpeechSegment(10, 16),
                ]),
                6.0,
                11.0,
            ],
            'monologue without speech segments' => [
                new Monologue([]),
                0.0,
                0.0,
            ],
        ];
    }
}
