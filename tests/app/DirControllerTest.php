<?php

namespace App;

use CodeIgniter\Test\CIUnitTestCase;
use CodeIgniter\Test\ControllerTestTrait;
use App\Libraries\Storage;
use App\Controllers\DirController;

class DirControllerTest extends CIUnitTestCase {
    use ControllerTestTrait;

    public function testDirectoryCreation() {
        $path = Storage::getStoragePath('test');
        $result = $this->withUri('http://localhost:8080/api/dir/create')
            ->controller(DirController::class)
            ->execute('create', 'test');
        
        $result->assertOK();
        $this->assertDirectoryExists($path);

        rmdir($path);
    }
    
    public function testMultiLevelDirectoryCreation() {
        $basePath = Storage::getStoragePath('test');
        $path = $basePath . '/test2';

        $result = $this->withUri('http://localhost:8080/api/dir/create')
            ->controller(DirController::class)
            ->execute('create', 'test/test2');
        
        $result->assertOK();
        $this->assertDirectoryExists($path);

        rmdir($path);
        rmdir($basePath);
    }
}