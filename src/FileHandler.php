<?php
declare(strict_types=1);

namespace App;

class FileHandler
{
    private mixed $handle;

    public function __construct(string $fileName)
    {
        $this->handle = fopen($fileName, 'r');
    }
    public function getFileContent(string $fileName): string
    {
        // TODO: Check if it's opened correctly
        $result = '';

        while (($line = fgets($this->handle)) !== false) {
            $result .= $line;
        }

        if ($this->handle === false) {
            echo 'Error opening';
            return '';
        }

        return trim($result);
    }

    public function __destruct()
    {
        fclose($this->handle);
    }
}