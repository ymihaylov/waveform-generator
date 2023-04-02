<?php
declare(strict_types=1);

namespace App\Tests\SilenceReversers;

use App\SilenceReversers\FfmpegFormatSilenceReverser;
use App\Conversation\Monologue;
use App\Conversation\SpeechSegment;
use App\Exceptions\SilenceReverserErrors\UnknownLineException;
use PHPUnit\Framework\TestCase;

class FfmpegFormatSilenceReverserTest extends TestCase
{
    /**
     * @dataProvider contentDataProvider
     * @throws UnknownLineException
     */
    public function testReverseSilenceContentToMonologue(string $content, Monologue $expectedMonologue): void
    {
        $silenceReverser = new FfmpegFormatSilenceReverser();

        $resultMonologue = $silenceReverser->reverseSilenceContentToMonologue($content);

        $this->assertEquals($expectedMonologue->toArray(), $resultMonologue->toArray());
    }

    public static function contentDataProvider(): array
    {
        return [
            'single silence segment' => [
                "[silencedetect @ 0x7fbfbbc076a0] silence_start: 10.214
[silencedetect @ 0x7fbfbbc076a0] silence_end: 12.214 | silence_duration: 2.00",
                new Monologue([
                    new SpeechSegment(0, 10.214),
                ]),
            ],
            'multiple silence segment' => [
                "[silencedetect @ 0x7fbfbbc076a0] silence_start: 3.504
[silencedetect @ 0x7fbfbbc076a0] silence_end: 6.656 | silence_duration: 3.152
[silencedetect @ 0x7fbfbbc076a0] silence_start: 14
[silencedetect @ 0x7fbfbbc076a0] silence_end: 19.712 | silence_duration: 5.712",
                new Monologue([
                    new SpeechSegment(0, 3.504),
                    new SpeechSegment(6.656, 14),
                ]),
            ],
            'no silence segments' => [
                "",
                new Monologue([]),
            ],
        ];
    }
}
