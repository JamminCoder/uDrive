<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Libraries\Storage;

class DirController extends BaseController {
    public function create() {
        $path = join('/', func_get_args());
        $absPath = Storage::getStoragePath($path);
        mkdir($absPath, recursive: true);

        return $this->response->setJSON(['message', 'Successfully created ' . $path]);
    }

    public function upload() {
        $path = join('/', func_get_args());
        $absPath = Storage::getStoragePath($path);
        if (!is_dir($absPath)) 
            return $this->response->setStatusCode(500, 'Path does not exist.');
        
        self::uploadDir($absPath, $_FILES['folder']);

        return $this->response->setJSON(["status" => "success"]);
    }


    private static function uploadDir($baseUploadPath, $files) {
        foreach ($files['name'] as $index => $file) {
            // Get the webkitRelativePath for this file
            $relativeFilePath = $files['full_path'][$index];

            // The final path when the file is uploaded
            $uploadPath = $baseUploadPath . DIRECTORY_SEPARATOR . $relativeFilePath;

            // Get the directory to where the file should be uploaded
            $explodedPath = explode(DIRECTORY_SEPARATOR, $uploadPath);
            array_pop($explodedPath);
            $dirPath = join(DIRECTORY_SEPARATOR, $explodedPath);
            
            if (!is_dir($dirPath)) mkdir($dirPath, recursive: true);
            
            // Upload it
            $tmpPath = $files['tmp_name'][$index];
            move_uploaded_file($tmpPath, $uploadPath);
        }
    }

}