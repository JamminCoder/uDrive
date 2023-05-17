<?php

use App\Libraries\FileSystem\UploadedItem;
use CodeIgniter\Test\CIUnitTestCase;
use App\Libraries\Storage;

class StorageTest extends CIUnitTestCase {
    public function testList() {
        $testDirName = '/test-dir';
        $hasDir = false;
        $hasFile = false;

        $baseDirPath = Storage::$root . $testDirName;
        if (!is_dir($baseDirPath)) mkdir($baseDirPath); 

        $filePath = "$baseDirPath/test.txt";
        $dirPath = "$baseDirPath/dir";

        file_put_contents($filePath, 'test');
        if (!is_dir($dirPath)) mkdir($dirPath);

        $items = Storage::ls($testDirName);
        $this->assertCount(2, $items);

        foreach ($items as $item) {
            if ($item->type == UploadedItem::FILE) $hasFile = true;
            if ($item->type == UploadedItem::DIR) $hasDir = true;
        }

        $this->assertTrue($hasDir);
        $this->assertTrue($hasFile);

        rmdir($dirPath);
        unlink($filePath);
        rmdir($baseDirPath);
    }
    
    public function testCannotAccessOutsideStorageDirectory() {
        $this->assertEquals(Storage::getStoragePath('../'), Storage::$root);
    }
}