<?php declare(strict_types=1);

namespace App;

use PHPUnit\Framework\TestCase;
use App\Libraries\FileSystem\UploadedItem;
use App\Libraries\FileSystem\FileItem;
use App\Libraries\FileSystem\DirItem;
use App\Libraries\Storage;

class UploadedItemTest extends TestCase {
    private string $filePath;

    public function __construct()
    {
        parent::__construct();
        $this->filePath = Storage::$root . '/test_item.txt';
        file_put_contents($this->filePath, 'Hello World!');
    }

    public function testUploadedItem() {
        $item = new UploadedItem($this->filePath);
        $this->assertEquals($item->path, $this->filePath);
        $this->assertEquals($item->type, UploadedItem::FILE);
        $this->assertEquals($item->isDir, false);
    }

    public function testFileItem() {
        $item = new FileItem($this->filePath);
        $this->assertEquals($item->type, UploadedItem::FILE);
        $this->assertEquals($item->isDir, false);
        $this->assertEquals($item->path, $this->filePath);
    }

    public function testDirItem() {
        $item = new DirItem(Storage::$root);
        $this->assertEquals($item->type, UploadedItem::DIR);
        $this->assertEquals($item->isDir, true);
        $this->assertEquals($item->path, Storage::$root);
    }


    /**
     * Not an actual test, just delete test file when done.
     */
    public function testRiskyCleanUp() {
        $this->assertTrue(unlink($this->filePath));
    }
}