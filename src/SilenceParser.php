<?php
declare(strict_types=1);

namespace App;
class SilenceParser
{
    public function reverseSilenceRawContentToMonologue(string $content): Monologue
    {
        $lines = explode(PHP_EOL, $content);

        return $this->parseLines($lines);
    }

    /**
     * @param string[] $lines
     * @return void
     */
    private function parseLines(array $lines): Monologue
    {
        $silenceStartAt = 0;
        $previousEndSilence = 0;

        $monologue = new Monologue();

        foreach ($lines as $line) {
            if (str_contains($line, 'silence_start') !== false) {
                // Process the silence_start line
                preg_match('/silence_start:\s*([\d.]+)/', $line, $matches);
                $silenceStartAt = floatval($matches[1]);
            } elseif (str_contains($line, 'silence_end')) {
                preg_match('/silence_end:\s*([\d.]+)/', $line, $matches);
                $silenceEndAt = floatval($matches[1]);

                $monologue->addSpeechSegment(new SpeechSegment($previousEndSilence, $silenceStartAt));
                $previousEndSilence = $silenceEndAt;
            } else {
                // This line doesn't contain either 'silence_start' or 'silence_end'
                echo "Unknown line: " . $line;
            }
        }

        return $monologue;
    }
}