<?php declare(strict_types=1);

namespace App;

use PHPUnit\Framework\TestCase;
use App\Libraries\FileSystem\UploadedItem;
use App\Libraries\FileSystem\FileItem;
use App\Libraries\FileSystem\DirItem;
use App\Libraries\Storage;

class UploadedItemTest extends TestCase {
    private string $fileName;
    private string $filePath;

    public function __construct()
    {
        parent::__construct();
        $this->fileName = 'test_item.txt';
        $this->filePath = Storage::$root . DIRECTORY_SEPARATOR . $this->fileName;
    }

    private function createTestFile() {
        file_put_contents($this->filePath, 'Hello World!');
    }

    private function deleteTestFile() {
        unlink($this->filePath);
    }

    public function testUploadedItem() {
        $item = new UploadedItem($this->filePath);
        $this->assertEquals($item->path, $this->filePath);
        $this->assertEquals($item->name, $this->fileName);
        $this->assertEquals($item->type, UploadedItem::FILE);
        $this->assertEquals($item->isDir, false);

    }

    public function testFileItem() {
        $this->createTestFile();
        $item = new FileItem($this->filePath);
        $this->assertEquals($item->type, UploadedItem::FILE);
        $this->assertEquals($item->isDir, false);
        $this->assertEquals($item->path, $this->filePath);
        $this->deleteTestFile();
    }

    public function testDirItem() {
        $item = new DirItem(Storage::$root);
        $this->assertEquals($item->type, UploadedItem::DIR);
        $this->assertEquals($item->isDir, true);
        $this->assertEquals($item->path, Storage::$root);
    }
}