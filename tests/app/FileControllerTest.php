<?php 

namespace App;

use App\Controllers\FileController;
use App\Libraries\Storage;
use CodeIgniter\HTTP\Files\UploadedFile;
use CodeIgniter\Test\CIUnitTestCase;
use CodeIgniter\Test\ControllerTestTrait;

class FileControllerTest extends CIUnitTestCase {
    use ControllerTestTrait;

    public function mockUpload($path='/') {
        /**
         * This is not working.
         * Find a way to test file uploads
         */
        // Create a temporary file to simulate the uploaded file
        $tempFilePath = tempnam(sys_get_temp_dir(), 'upload_test');
        file_put_contents($tempFilePath, 'test data');

        // Create an UploadedFile instance
        $uploadedFile = new UploadedFile(
            $tempFilePath,
            'test.txt',
            'text/plain',
            filesize($tempFilePath),
            UPLOAD_ERR_OK,
            true
        );

        $result = $this->withUri('http://localhost:8080/api/upload')
            ->withBody(['files' => $uploadedFile])
            ->controller(FileController::class)
            ->execute('upload', $path);
        

        unlink($tempFilePath);
        return $result;
    }

    public function testFileUpload()
    {
        $result = $this->mockUpload();
        $result->assertOK();
    }

    public function testFileUploadWhenFileExists() {
        $path = Storage::getStoragePath('test-exists.txt');
        file_put_contents($path, 'hello!');
        $result = $this->mockUpload('test-exists.txt');
        $result->assertNotOK();

        unlink($path);
    }

    public function testFileUploadToDirectory() {
        $uploadTestDir = '/upload-test';
        $dirPath = Storage::$root . $uploadTestDir;
        if (!is_dir($dirPath)) mkdir($dirPath);

        $result = $this->mockUpload($uploadTestDir);
        $result->assertOK();
        
        $result = $this->mockUpload('/non-existent');
        $result->assertStatus(500);

        rmdir($dirPath);
    }

    public function testFileCreation() {
        $result = $this->withUri('http://localhost:8080/api/create')
            ->controller(FileController::class)
            ->execute('create', 'test.txt');
        $result->assertOK();
    }

    public function testFileDeletion() {
        $testPath = Storage::$root . '/test.txt';
        file_put_contents($testPath, 'Hello world!');

        $result = $this->withUri('http://localhost:8080/api/delete')
            ->controller(FileController::class)
            ->execute('delete', 'test.txt');


        $result->assertOK();
        $this->assertFileDoesNotExist($testPath);
    }
}