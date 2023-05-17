<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Libraries\Storage;
use Symfony\Component\Filesystem\Filesystem;

class DirController extends BaseController {
    public function create() {
        $path = join('/', func_get_args());
        $absPath = Storage::getStoragePath($path);
        $fs = new Filesystem();
        $fs->mkdir($absPath);

        return $this->response->setJSON(['message', 'Successfully created ' . $path]);
    }
}