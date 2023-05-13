<?php

use CodeIgniter\Test\CIUnitTestCase;
use App\Libraries\Storage;

class StorageTest extends CIUnitTestCase {
    public function testCannotAccessOutsideStorageDirectory() {
        $this->assertEquals(Storage::getStoragePath('../'), Storage::$root);
    }
}