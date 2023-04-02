<?php
declare(strict_types=1);

namespace Conversation;

use App\Conversation\Monologue;
use App\Conversation\SpeechSegment;
use PHPUnit\Framework\TestCase;

class MonologueTest extends TestCase
{
    /**
     * @dataProvider monologueDataProvider
     */
    public function testMonologue(
        array $speechSegments,
        ?SpeechSegment $expectedLongestSpeechSegment,
        float $expectedTotalDuration,
        array $expectedMonologueToArrayResult
    ): void {
        $monologue = new Monologue($speechSegments);

        $this->assertEquals($expectedLongestSpeechSegment, $monologue->getLongestSpeechSegment());
        $this->assertEquals($expectedTotalDuration, $monologue->getTotalDuration());
        $this->assertSame($expectedMonologueToArrayResult, $monologue->toArray());
    }

    public static function monologueDataProvider(): array
    {
        $speechSegment1 = new SpeechSegment(0, 10);
        $speechSegment2 = new SpeechSegment(10, 20);
        $speechSegment3 = new SpeechSegment(20, 35);

        return [
            'no speech segments' => [
                [],
                null,
                0.0,
                [],
            ],
            'single speech segment' => [
                [$speechSegment1],
                $speechSegment1,
                10.0,
                [$speechSegment1->toArray()],
            ],
            'multiple speech segments' => [
                [$speechSegment1, $speechSegment2, $speechSegment3],
                $speechSegment3,
                35.0,
                [
                    $speechSegment1->toArray(),
                    $speechSegment2->toArray(),
                    $speechSegment3->toArray(),
                ],
            ],
            'multiple speech segments with same duration' => [
                [$speechSegment1, $speechSegment2],
                $speechSegment2, // Always the last segment
                20.0,
                [
                    $speechSegment1->toArray(),
                    $speechSegment2->toArray(),
                ],
            ],
        ];
    }
}
