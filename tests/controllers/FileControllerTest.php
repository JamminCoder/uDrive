<?php 
// declare(strict_types=1);

namespace App;

use CodeIgniter\Test\FeatureTestTrait;
use CodeIgniter\HTTP\Files\UploadedFile;
use CodeIgniter\Test\CIUnitTestCase;

class FileControllerTest extends CIUnitTestCase {
    use FeatureTestTrait;

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

        unlink($tempFilePath);
        $result = $this->call('POST', '/api/upload', ['files' => $uploadedFile]);
        return $result;
    }

    public function testFileUpload()
    {
        $result = $this->mockUpload();
        $result->assertOK();
    }
}