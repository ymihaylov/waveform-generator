<?php
declare(strict_types=1);

namespace Conversation;

use App\Conversation\SpeechSegment;
use InvalidArgumentException;
use PHPUnit\Framework\TestCase;

class SpeechSegmentTest extends TestCase
{
    /**
     * @dataProvider speechSegmentDataProvider
     */
    public function testSpeechSegment(
        float $startTalkingAt,
        float $endTalkingAt,
        float $expectedDuration,
        array $expectedToArrayResult
    ): void {
        $speechSegment = new SpeechSegment($startTalkingAt, $endTalkingAt);

        $this->assertEquals($expectedDuration, $speechSegment->getDuration());
        $this->assertSame($expectedToArrayResult, $speechSegment->toArray());
    }

    public static function speechSegmentDataProvider(): array
    {
        return [
            'valid speech segment' => [
                1.0,
                5.0,
                4.0,
                [1.0, 5.0],
            ],
            'valid speech segment with decimals' => [
                1.123,
                5.789,
                4.666,
                [1.123, 5.789],
            ],
        ];
    }

    /**
     * @dataProvider invalidSpeechSegmentDataProvider
     */
    public function testInvalidSpeechSegment(float $startTalkingAt, float $endTalkingAt): void
    {
        $this->expectException(InvalidArgumentException::class);

        new SpeechSegment($startTalkingAt, $endTalkingAt);
    }

    public static function invalidSpeechSegmentDataProvider(): array
    {
        return [
            'start talking at is equal to end talking at' => [
                5.0,
                5.0,
            ],
            'start talking at is greater than end talking at' => [
                10.0,
                5.0,
            ],
        ];
    }
}
