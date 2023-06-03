<?php 

namespace App;

use App\Controllers\FileController;
use App\Libraries\Storage;
use CodeIgniter\Test\CIUnitTestCase;
use CodeIgniter\Test\ControllerTestTrait;

class FileControllerTest extends CIUnitTestCase {
    use ControllerTestTrait;

    private function uploadFile($path='', $fileName='test.txt') {
        $curlFile = new \CURLStringFile('Uploaded file', $fileName, 'text/plain');

        $ch = curl_init("http://localhost:8080/api/upload/$path");
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1); // Don't print curl output
        curl_setopt($ch, CURLOPT_POSTFIELDS, [
            'files[]' => $curlFile,
        ]);

        curl_exec($ch);
        curl_close($ch);
        return curl_getinfo($ch);
    }

    public function testFileUpload() {
        $filePath = Storage::getStoragePath('test.txt');
        $result = $this->uploadFile();
        $this->assertEquals(200, $result['http_code']);
        $this->assertFileExists($filePath);
        unlink($filePath);
    }

    public function testFileUploadWhenFileExists() {
        $existingFile = Storage::getStoragePath('test.txt');
        $uploadedFilePath = Storage::getStoragePath('test_1.txt');
        file_put_contents($existingFile, 'hello!');
        
        $result = $this->uploadFile();
        
        $this->assertEquals(200, $result['http_code']);
        $this->assertFileExists($uploadedFilePath);

        unlink($existingFile);
        unlink($uploadedFilePath);
    }

    public function testFileUploadToDirectory() {
        $uploadTestDir = '/upload-test';
        $dirPath = Storage::getStoragePath($uploadTestDir);
        $uploadedFilePath = "$dirPath/test.txt";
        if (!is_dir($dirPath)) mkdir($dirPath);

        $result = $this->uploadFile(path: $uploadTestDir);
        $this->assertEquals(200, $result['http_code']);
        
        $result = $this->uploadFile(path: 'non-existent');
        $this->assertEquals(500, $result['http_code']);

        unlink($uploadedFilePath);
        rmdir($dirPath);
    }

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