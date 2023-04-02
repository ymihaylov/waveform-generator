<?php
declare(strict_types=1);

namespace AnalysisResults;

use App\AnalysisResults\ChannelAnalysisResult;
use App\AnalysisResults\ConversationAnalysisResult;
use App\Conversation\Monologue;
use App\Conversation\SpeechSegment;
use PHPUnit\Framework\TestCase;

class ConversationAnalysisResultTest extends TestCase
{
    /**
     * @dataProvider conversationDataProvider
     */
    public function testToArray(ChannelAnalysisResult $userChannelAnalysis, ChannelAnalysisResult $customerChannelAnalysis, array $expectedResult): void
    {
        $conversationAnalysisResult = new ConversationAnalysisResult($userChannelAnalysis, $customerChannelAnalysis);

        $this->assertSame($expectedResult, $conversationAnalysisResult->toArray());
    }

    public static function conversationDataProvider(): array
    {
        /**
         * Scenario 1
         */
        $userMonologue1 = new Monologue([
            new SpeechSegment(0, 10),
        ]);
        $customerMonologue1 = new Monologue([
            new SpeechSegment(10, 20),
        ]);
        $userChannelAnalysis1 = new ChannelAnalysisResult($userMonologue1);
        $customerChannelAnalysis1 = new ChannelAnalysisResult($customerMonologue1);

        $scenarios['scenario 1'] = [
            $userChannelAnalysis1,
            $customerChannelAnalysis1,
            [
                'longest_user_monologue' => 10.0,
                'longest_customer_monologue' => 10.0,
                'user_talk_percentage' => 50.0,
                'user' => $userChannelAnalysis1->getChannelData(),
                'customer' => $customerChannelAnalysis1->getChannelData(),
            ],
        ];

        /**
         * Scenario 2
         */
        $userMonologue2 = new Monologue([
            new SpeechSegment(0, 15),
            new SpeechSegment(31, 60),
        ]);
        $customerMonologue2 = new Monologue([
            new SpeechSegment(15, 30),
        ]);

        $userChannelAnalysis2 = new ChannelAnalysisResult($userMonologue2);
        $customerChannelAnalysis2 = new ChannelAnalysisResult($customerMonologue2);

        $scenarios['scenario 2'] = [
            $userChannelAnalysis2,
            $customerChannelAnalysis2,
            [
                'longest_user_monologue' => 29.0,
                'longest_customer_monologue' => 15.0,
                'user_talk_percentage' => 74.576,
                'user' => $userChannelAnalysis2->getChannelData(),
                'customer' => $customerChannelAnalysis2->getChannelData(),
            ],
        ];

        return $scenarios;
    }
}
