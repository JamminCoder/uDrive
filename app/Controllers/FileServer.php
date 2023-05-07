<?php

namespace App\Controllers;
use App\Libraries\Storage;

class FileServer extends BaseController {
    public function index() {
        $path = join('/', func_get_args());
        $files = Storage::ls($path);
        return $this->response->setJSON(['files' => $files]);
    }

    public function serve($path) {
        $path = join('/', func_get_args());
        $filePath = Storage::getStoragePath($path);
        $this->response->setHeader('Content-Type', mime_content_type($filePath));
        readfile($filePath);
    }
};