<?php
declare(strict_types=1);

namespace App\Utils;

class FileContentReader
{
    private mixed $handle;

    public function __construct(string $fileName)
    {
        $this->handle = fopen($fileName, 'r');

        if ($this->handle === false) {
            throw new \RuntimeException("Error opening the file.");
        }
    }

    public function getFileContent(): string
    {
        $content = '';
        while (($line = fgets($this->handle)) !== false) {
            $content .= $line;
        }

        return trim($content);
    }

    public function __destruct()
    {
        fclose($this->handle);
    }
}