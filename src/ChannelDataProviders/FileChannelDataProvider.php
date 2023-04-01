<?php
declare(strict_types=1);

namespace App\ChannelDataProviders;

use App\Utils\FileHandler;

class FileChannelDataProvider implements ChannelDataProviderInterface
{
    public function __construct(
        readonly private FileHandler $fileHandler
    ) {}

    public function getData(): string
    {
        return $this->fileHandler->getFileContent();
    }
}
