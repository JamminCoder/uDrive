<?php 
// declare(strict_types=1);

namespace App;

use CodeIgniter\Test\FeatureTestTrait;
use CodeIgniter\HTTP\Files\UploadedFile;
use CodeIgniter\Test\CIUnitTestCase;

class TestUploadController extends CIUnitTestCase {
    use FeatureTestTrait;

    private function mockUpload($referrer=null) {
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

        // set referer
        $headers = [
            'Referrer' => $referrer
        ];

        $result = $this->withHeaders($headers)->call('POST', '/api/upload', ['files' => $uploadedFile]);
        return $result;
    }

    public function testFileUpload()
    {
        $result = $this->mockUpload();
        $result->assertOK();
    }

    public function testFileUploadWithReferer() {
        $result = $this->mockUpload('http://localhost:8080/');
        $result->assertRedirect();
    }
}