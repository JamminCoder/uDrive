<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Libraries\Storage;
use Symfony\Component\Filesystem\Filesystem;

class DirController extends BaseController {
    public function create(...$pathArray) {
        $path = join('/', $pathArray);
        $absPath = Storage::getStoragePath($path);
        mkdir($absPath, recursive: true);

        return $this->response->setJSON(['message', "Successfully created $path"]);
    }

    public function delete(...$pathArray) {
        $path = join('/', $pathArray);
        $absPath = Storage::getStoragePath($path);
        (new Filesystem())->remove($absPath);

        return $this->response->setJSON(['message' => "Successfully deleted $path"]);
    }

    public function upload(...$pathArray) {
        $path = join('/', $pathArray);
        $absPath = Storage::getStoragePath($path);
        if (!is_dir($absPath)) 
            return $this->response->setStatusCode(500, 'Path does not exist.');
        
        $files = $this->request->getFiles();
        foreach ($files["folder"] as $file) {
            // The final path when the file is uploaded
            $fullUploadedFilePath = $absPath . DIRECTORY_SEPARATOR . $file->getClientPath();

            $uploadDir = self::chompFileName($fullUploadedFilePath);
            
            // Make new directory if needed.
            if (!is_dir($uploadDir)) mkdir($uploadDir, recursive: true);

            $file->move($fullUploadedFilePath);
        }

        return $this->response->setJSON(["status" => "success"]);
    }


    private static function chompFileName($filePath) {
        $explodedPath = explode(DIRECTORY_SEPARATOR, $filePath);
        array_pop($explodedPath);
        return join(DIRECTORY_SEPARATOR, $explodedPath);
    }
}