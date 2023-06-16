<?php 

namespace App;

use App\Controllers\FileController;
use App\Libraries\Storage;
use CodeIgniter\Test\CIUnitTestCase;
use CodeIgniter\Test\ControllerTestTrait;

class FileControllerTest extends CIUnitTestCase {
    use ControllerTestTrait;

    public function testFileCreation() {
        $result = $this->withUri('http://localhost:8080/api/create/test.txt')
            ->controller(FileController::class)
            ->execute('create', 'test.txt');
        $result->assertOK();
    }

    public function testFileDeletion() {
        $testPath = Storage::getStoragePath('test.txt');
        file_put_contents($testPath, 'Hello world!');

        $result = $this->withUri('http://localhost:8080/api/delete/test.txt')
            ->controller(FileController::class)
            ->execute('delete', 'test.txt');

        $result->assertOK();
        $this->assertFileDoesNotExist($testPath);
    }
}