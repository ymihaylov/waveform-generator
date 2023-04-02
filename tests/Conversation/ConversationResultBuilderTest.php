<?php
declare(strict_types=1);

namespace Conversation;

use App\Conversation\ConversationResultBuilder;
use App\Conversation\Monologue;
use App\Conversation\SpeechSegment;
use App\AnalysisResults\ConversationAnalysisResult;
use PHPUnit\Framework\TestCase;

class ConversationResultBuilderTest extends TestCase
{
    /**
     * @dataProvider monologueDataProvider
     */
    public function testBuild(Monologue $userMonologue, Monologue $customerMonologue): void
    {
        $conversationResultBuilder = new ConversationResultBuilder();

        $conversationAnalysisResult = $conversationResultBuilder->build($userMonologue, $customerMonologue);

        $this->assertInstanceOf(ConversationAnalysisResult::class, $conversationAnalysisResult);

        $resultArray = $conversationAnalysisResult->toArray();

        $this->assertSame($userMonologue->getLongestSpeechSegment()?->getDuration() ?? 0.0, $resultArray['longest_user_monologue']);
        $this->assertSame($customerMonologue->getLongestSpeechSegment()?->getDuration() ?? 0.0, $resultArray['longest_customer_monologue']);
    }

    public static function monologueDataProvider(): array
    {
        return [
            'sample monologues' => [
                new Monologue([
                    new SpeechSegment(0, 10),
                    new SpeechSegment(20, 30),
                ]),
                new Monologue([
                    new SpeechSegment(10, 20),
                    new SpeechSegment(30, 40),
                ]),
            ],
            'empty monologues' => [
                new Monologue([]),
                new Monologue([]),
            ],
        ];
    }
}