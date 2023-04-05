<?php
declare(strict_types=1);

namespace App\Tests\Utils;

use App\Utils\FileContentReader;
use PHPUnit\Framework\TestCase;

class FileContentReaderTest extends TestCase
{
    private string $tempFilePath;
    protected function setUp(): void
    {
        parent::setUp();

        // Create a temporary file with some content
        $this->tempFilePath = __DIR__ . '/test_file_content_reader.txt';
        file_put_contents($this->tempFilePath, "This is a test.\nAnother line of text.\n");
    }
    public function testGetFileContent(): void
    {
        $fileContentReader = new FileContentReader($this->tempFilePath);
        $content = $fileContentReader->getFileContent();

        $this->assertSame("This is a test.\nAnother line of text.", $content);
    }

    public function testErrorOpeningFile(): void
    {
        $this->expectException(\RuntimeException::class);
        $this->expectExceptionMessage("Error opening the file.");

        $invalidFileName = 'non_existing_file.txt';
        new FileContentReader($invalidFileName);
    }
    protected function tearDown(): void
    {
        // Clean up the temporary file
        @unlink($this->tempFilePath);

        parent::tearDown();
    }


}
