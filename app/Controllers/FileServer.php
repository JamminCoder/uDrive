<?php

namespace App\Controllers;
use App\Libraries\Files;

class FileServer extends BaseController {
    public function index($path=false) {
        $path = join('/', func_get_args());
        $files = Files::ls($path);
        return $this->response->setJSON(['files' => $files]);
    }
};