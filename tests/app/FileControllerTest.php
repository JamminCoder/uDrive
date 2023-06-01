<?php 

namespace App;

use App\Controllers\DirController;
use App\Controllers\FileController;
use App\Libraries\Storage;
use CodeIgniter\HTTP\Files\UploadedFile;
use CodeIgniter\Test\CIUnitTestCase;
use CodeIgniter\Test\ControllerTestTrait;
use CodeIgniter\Test\FeatureTestTrait;

class FileControllerTest extends CIUnitTestCase {
    // use ControllerTestTrait;
    use FeatureTestTrait;

    public function mockUpload($path='/') {
        if (!$path[0] == '/' && strlen($path) > 1) $path = '/' . $path;

        // Create a temporary file to simulate the uploaded file
        $tempFilePath = tempnam(sys_get_temp_dir(), 'upload_test');
        file_put_contents($tempFilePath, 'test data');

        // Create an UploadedFile instance
        $file = [
            'name' => 'test.txt',
            'type' => 'text/plain',
            'tmp_name' => $tempFilePath,
            'error' => 0,
        ];
        
        $result = $this->post("api/upload$path", [
            'file' => $file
        ]);
    
        unlink($tempFilePath);
        return $result;
    }

    public function testFileUpload()
    {        
        $result = $this->mockUpload();
        $result->assertOK();

        $filePath = Storage::getStoragePath('test.txt');
        unlink($filePath);
    }

    public function testFileUploadWhenFileExists() {
        $path = Storage::getStoragePath('test.txt');
        file_put_contents($path, 'hello!');
        $result = $this->mockUpload();
        $result->assertOK();

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
        $result = $this->post('api/create/test.txt');
        $result->assertOK();
    }

    public function testFileDeletion() {
        $testPath = Storage::getStoragePath('test.txt');
        file_put_contents($testPath, 'Hello world!');

        $result = $this->post('api/delete/test.txt');
        $result->assertOK();

        if (file_exists($testPath)) unlink($testPath);
    }   
}