<?php

declare(strict_types=1);

namespace App\Utils;

class FileContentReader
{
    private mixed $handle;

    /**
     * @param string $fileName
     */
    public function __construct(string $fileName)
    {
        $this->handle = fopen($fileName, 'r');

        if ($this->handle === false) {
            throw new \RuntimeException("Error opening the file.");
        }
    }

    /**
     * @return string
     */
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
