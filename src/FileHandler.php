<?php
declare(strict_types=1);

namespace App;

class FileHandler
{
    public function getFileContent(string $fileName): string
    {
        // TODO: Check if it's opened correctly
        $handle = fopen($fileName, 'r');

        $result = '';

        while (($line = fgets($handle)) !== false) {
            $result .= $line;
        }

        if ($handle === false) {
            echo 'Error opening';
            return '';
        }

        fclose($handle);

        return trim($result);
    }
}