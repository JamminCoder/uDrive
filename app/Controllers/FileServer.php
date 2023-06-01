<?php

namespace App\Controllers;
use App\Libraries\Storage;

class FileServer extends BaseController {
    public function index(...$pathArray) {
        $path = join('/', $pathArray);
        if (is_dir(Storage::$root . "/$path")) {
            return $this->response->setJSON(['files' => Storage::ls($path)]);
        }
        else {
            $this->serve($path);
        }
    }

    private function serve($path) {
        $filePath = Storage::getStoragePath($path);
        $this->response->setHeader('Content-Type', mime_content_type($filePath));
        readfile($filePath);
    }
};