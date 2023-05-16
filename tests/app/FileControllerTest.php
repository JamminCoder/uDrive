<?php 
// declare(strict_types=1);

namespace App;

use App\Controllers\FileController;
use App\Libraries\Storage;
use CodeIgniter\HTTP\Files\UploadedFile;
use CodeIgniter\Test\CIUnitTestCase;
use CodeIgniter\Test\ControllerTestTrait;

class FileControllerTest extends CIUnitTestCase {
    use ControllerTestTrait;

    private function mockUpload($path='/') {
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

        $result = $this->withUri('http://localhost:8080')
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

    public function testFileUploadToDirectory() {
        $dirPath = Storage::$root . '/upload-test';
        if (!is_dir($dirPath)) mkdir($dirPath);

        $result = $this->mockUpload('/upload-test');
        $result->assertOK();
        
        $result = $this->mockUpload('/non-existent');
        $result->assertStatus(500);

        rmdir($dirPath);
    }


    public function testFileDeletion() {
        $testPath = Storage::$root . '/test.txt';
        file_put_contents($testPath, 'Hello world!');

        $result = $this->withUri('http://localhost:8080')
            ->controller(FileController::class)
            ->execute('delete', 'test.txt');


        $result->assertOK();
        $this->assertFileDoesNotExist($testPath);
    }
}