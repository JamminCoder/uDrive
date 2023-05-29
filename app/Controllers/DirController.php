<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Libraries\Storage;
use CodeIgniter\HTTP\Files\UploadedFile;
use Symfony\Component\Filesystem\Filesystem;

class DirController extends BaseController {
    public function create() {
        $path = join('/', func_get_args());
        $absPath = Storage::getStoragePath($path);
        $fs = new Filesystem();
        $fs->mkdir($absPath);

        return $this->response->setJSON(['message', 'Successfully created ' . $path]);
    }

    public function upload() {
        $path = join('/', func_get_args());
        $absPath = Storage::getStoragePath($path);
        $fs = new Filesystem();
        if (!is_dir($absPath)) {
            return $this->response->setStatusCode(500, 'Path does not exist.');
        }
        
        $files = $_FILES['folder'];

        foreach ($files['name'] as $index => $file) {
            $uploadPath = 
            $absPath . DIRECTORY_SEPARATOR 
            . $files['full_path'][$index];

            $explodedPath = explode(DIRECTORY_SEPARATOR, $uploadPath);
            array_pop($explodedPath);
            $dirPath = join(DIRECTORY_SEPARATOR, $explodedPath);

            if (!is_dir($dirPath)) 
                mkdir($dirPath, recursive: true);

            move_uploaded_file($files['tmp_name'][$index], $uploadPath);
        }

        return $this->response->setJSON(["status" => "success"]);
    }

}