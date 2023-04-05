<?php

declare(strict_types=1);

namespace App\Tests;

use App\AnalysisResults\ChannelAnalysisResult;
use App\AnalysisResults\ConversationAnalysisResult;
use App\Application;

use App\ChannelDataProviders\ChannelDataProviderInterface;
use App\Conversation\ConversationResultBuilder;
use App\Conversation\Monologue;
use App\SilenceReversers\SilenceToMonologueReverserInterface;
use PHPUnit\Framework\MockObject\Exception;
use PHPUnit\Framework\TestCase;

class ApplicationTest extends TestCase
{
    /**
     * @throws Exception
     */
    public function testRun(): void
    {
        $userMonologue = new Monologue();
        $customerMonologue = new Monologue();

        $userChannelDataProvider = $this->createMock(ChannelDataProviderInterface::class);
        $customerChannelDataProvider = $this->createMock(ChannelDataProviderInterface::class);

        $silenceToMonologueReverser = $this->createMock(SilenceToMonologueReverserInterface::class);
        $silenceToMonologueReverser
            ->expects($this->exactly(2))
            ->method('reverseSilenceContentToMonologue')
            ->willReturnOnConsecutiveCalls($userMonologue, $customerMonologue);


        $conversationAnalysisResult = new ConversationAnalysisResult(
            new ChannelAnalysisResult($userMonologue), new ChannelAnalysisResult($customerMonologue)
        );
        $conversationResultBuilder = $this->createMock(ConversationResultBuilder::class);
        $conversationResultBuilder
            ->expects($this->once())
            ->method('build')
            ->with($userMonologue, $customerMonologue)
            ->willReturn($conversationAnalysisResult);

        $application = new Application(
            $userChannelDataProvider,
            $customerChannelDataProvider,
            $silenceToMonologueReverser,
            $conversationResultBuilder
        );

        $result = $application->run();

        $this->assertInstanceOf(ConversationAnalysisResult::class, $result);
        $this->assertSame($conversationAnalysisResult, $result);
    }
}