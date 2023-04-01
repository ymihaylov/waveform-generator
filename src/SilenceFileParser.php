<?php
declare(strict_types=1);

namespace App;
class SilenceFileParser
{
    public function reverseSilenceFileToMonologueArray(string $fileName): Monologue
    {
        // TODO: Check if it's opened correctly.
        $handle = $this->openFile($fileName);

        if ($handle === false) {
            echo 'Error opening';
            return [];
        }

        $monologue = $this->parseFile($handle);
        fclose($handle);

        return $monologue;
    }

    private function parseFile($handle): Monologue
    {
        $result = [];

        $silenceStartAt = 0;
        $previousEndSilence = 0;

        $monologue = new Monologue();

        while (($line = fgets($handle)) !== false) {
            if (str_contains($line, 'silence_start') !== false) {
                // Process the silence_start line
                preg_match('/silence_start:\s*([\d.]+)/', $line, $matches);
                $silenceStartAt = floatval($matches[1]);
            } elseif (str_contains($line, 'silence_end')) {
                preg_match('/silence_end:\s*([\d.]+)/', $line, $matches);
                $silenceEndAt = floatval($matches[1]);

//                $result[] = [$previousEndSilence, $silenceStartAt];
                $monologue->addSpeechSegment(new SpeechSegment($previousEndSilence, $silenceStartAt));
                $previousEndSilence = $silenceEndAt;
            } else {
                // This line doesn't contain either 'silence_start' or 'silence_end'
                echo "Unknown line: " . $line;
            }
        }
        return $monologue;
    }

    private function openFile(string $fileName)
    {
        return fopen($fileName, 'r');
    }
}