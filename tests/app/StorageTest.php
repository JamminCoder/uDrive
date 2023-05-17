<?php

use App\Libraries\FileSystem\UploadedItem;
use CodeIgniter\Test\CIUnitTestCase;
use App\Libraries\Storage;
use Symfony\Component\Filesystem\Filesystem;

class StorageTest extends CIUnitTestCase {
    public function testList() {
        $testDirName = '/test-dir';
        $hasDir = false;
        $hasFile = false;
        $fs = new Filesystem();
        $baseDirPath = Storage::$root . $testDirName;
        $filePath = "$baseDirPath/test.txt";
        $dirPath = "$baseDirPath/dir";

        $fs->mkdir($dirPath);
        $fs->touch($filePath);

        $items = Storage::ls($testDirName);
        $this->assertCount(2, $items);

        foreach ($items as $item) {
            if ($item->type == UploadedItem::FILE) $hasFile = true;
            if ($item->type == UploadedItem::DIR) $hasDir = true;
        }

        $this->assertTrue($hasDir);
        $this->assertTrue($hasFile);

        $fs->remove($baseDirPath);
    }
    
    public function testCannotAccessOutsideStorageDirectory() {
        $this->assertEquals(Storage::getStoragePath('../'), Storage::$root);
    }
}