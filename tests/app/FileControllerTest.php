<?php 
// declare(strict_types=1);

namespace App;

use App\Controllers\FileController;
use App\Libraries\Storage;
use CodeIgniter\Test\FeatureTestTrait;
use CodeIgniter\HTTP\Files\UploadedFile;
use CodeIgniter\Test\CIUnitTestCase;
use CodeIgniter\Test\ControllerTestTrait;

class FileControllerTest extends CIUnitTestCase {
    use ControllerTestTrait;

    private function mockUpload() {
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
            ->controller(\App\Controllers\FileController::class)
            ->execute('upload');
        

        unlink($tempFilePath);
        return $result;
    }

    public function testFileUpload()
    {
        $result = $this->mockUpload();
        $result->assertOK();
    }


    public function testFileDeletion() {
        file_put_contents(Storage::$root . '/test.txt', 'Hello world!');

        $result = $this->withUri('http://localhost:8080')
            ->controller(\App\Controllers\FileController::class)
            ->execute('delete', 'test.txt');


        $result->assertOK();
        $this->assertFileDoesNotExist(Storage::$root . '/test.txt');
    }
}