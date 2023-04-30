<?php

namespace App\Controllers;
use App\Libraries\Storage;

class FileServer extends BaseController {
    public function index() {
        $path = join('/', func_get_args());
        $files = Storage::ls($path);
        return $this->response->setJSON(['files' => $files]);
    }
};