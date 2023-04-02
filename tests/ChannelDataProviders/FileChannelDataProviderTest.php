<?php
declare(strict_types=1);

namespace ChannelDataProviders;

use PHPUnit\Framework\MockObject\Exception;
use App\ChannelDataProviders\FileChannelDataProvider;
use App\Utils\FileContentReader;
use PHPUnit\Framework\TestCase;

class FileChannelDataProviderTest extends TestCase
{
    /**
     * @dataProvider fileContentDataProvider
     * @throws Exception
     */
    public function testGetData(string $fileContent): void
    {
        $fileContentReaderMock = $this->createMock(FileContentReader::class);
        $fileContentReaderMock
            ->method('getFileContent')
            ->willReturn($fileContent);

        $fileChannelDataProvider = new FileChannelDataProvider($fileContentReaderMock);

        $this->assertSame($fileContent, $fileChannelDataProvider->getData());
    }

    public static function fileContentDataProvider(): array
    {
        return [
            'empty file' => [
                '',
            ],
            'file with content' => [
                'This is a sample content.',
            ],
            'file with multiline content' => [
                "This is a sample content.\nAnother line of content.",
            ],
        ];
    }
}
