<?php
declare(strict_types=1);

namespace App\SilenceReversers;

use App\Conversation\Monologue;
use App\Conversation\SpeechSegment;
use App\Exceptions\SilenceReverserErrors\UnknownLineException;

class FfmpegFormatSilenceReverser implements SilenceToMonologueReverserInterface
{
    private float $currentSilenceStartAt = 0;
    private float $previousSilenceEndAt = 0;

    /**
     * @throws UnknownLineException
     */
    public function reverseSilenceContentToMonologue(string $content): Monologue
    {
        $this->resetStateProperties();

        $lines = explode(PHP_EOL, $content);

        return $this->processSilenceData($lines);
    }

    /**
     * @param string[] $lines
     * @return Monologue
     * @throws UnknownLineException
     */
    private function processSilenceData(array $lines): Monologue
    {
        $monologue = new Monologue();

        foreach ($lines as $line) {
            try {
                if (str_contains($line, 'silence_start') !== false) {
                    $this->processSilenceStartLine($line);
                } elseif (str_contains($line, 'silence_end')) {
                    $this->processSilenceEndLine($line, $monologue);
                } else {
                    throw new UnknownLineException($line);
                }
            } catch (UnknownLineException $e) {}
        }

        return $monologue;
    }

    /**
     * @param string $line
     * @return void
     */
    private function processSilenceStartLine(string $line): void
    {
        preg_match('/silence_start:\s*([\d.]+)/', $line, $matches);
        $this->currentSilenceStartAt = floatval($matches[1]);
    }

    /**
     * @param string $line
     * @param Monologue $monologue
     * @return void
     */
    private function processSilenceEndLine(string $line, Monologue $monologue): void
    {
        preg_match('/silence_end:\s*([\d.]+)/', $line, $matches);
        $silenceEndAt = floatval($matches[1]);

        $monologue->addSpeechSegment(new SpeechSegment($this->previousSilenceEndAt, $this->currentSilenceStartAt));
        $this->previousSilenceEndAt = $silenceEndAt;
    }

    /**
     * @return void
     */
    private function resetStateProperties(): void
    {
        $this->currentSilenceStartAt = 0;
        $this->previousSilenceEndAt = 0;
    }
}
