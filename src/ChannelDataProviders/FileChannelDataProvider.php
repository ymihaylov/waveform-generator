<?php

declare(strict_types=1);

namespace App\ChannelDataProviders;

use App\Utils\FileContentReader;

readonly class FileChannelDataProvider implements ChannelDataProviderInterface
{
    public function __construct(
        private FileContentReader $fileHandler
    ) {}

    public function getData(): string
    {
        return $this->fileHandler->getFileContent();
    }
}
