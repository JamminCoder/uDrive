<?php

namespace App\Controllers;
use App\Controllers\BaseController;


class UploadController extends BaseController {
    public function upload() {
        $files = $this->request->getFiles('files');
        foreach ($files as $file) $file->move(WRITEPATH . 'storage');

        return redirect()->to('/');
    }
}