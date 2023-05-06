<?php declare(strict_types=1);

use PHPUnit\Framework\TestCase;


/**
 * @param string | null $referer
 * Optional referer header to send with the request
 * @return int
 * HTTP Status code of the response
 */
function uploadFile($referer=null): int {
    // TODO: Replace with codeigniter feature test

    // Temp file
    $tempFilePath = tempnam(sys_get_temp_dir(), 'upload_test');
    file_put_contents($tempFilePath, 'test data');
    
    $uploadUrl = 'http://localhost:8080/api/upload';

    $cURLConnection = curl_init($uploadUrl);
    curl_setopt($cURLConnection, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($cURLConnection, CURLOPT_POST, true);
    curl_setopt($cURLConnection, CURLOPT_POSTFIELDS, [
        'files' => new CurlFile($tempFilePath)
    ]);

    if ($referer) curl_setopt($cURLConnection, CURLOPT_REFERER, $referer);
    
    curl_exec($cURLConnection);
    curl_close($cURLConnection);

    $status = curl_getinfo($cURLConnection, CURLINFO_HTTP_CODE);
    return $status;
}

class FileUploadTest extends TestCase {
    public function testFileUpload() {
        $status = uploadFile();
        $this->assertEquals(200, $status);
        error_log("$status");
    }

    public function testFileUploadWithReferer() {
        $status = uploadFile('http://localhost:8080/');
        $this->assertEquals(303, $status);
        error_log("$status");
    }
}