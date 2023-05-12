<?php

namespace App\Controllers;
use App\Controllers\BaseController;
use App\Libraries\Storage;
use Symfony\Component\Filesystem\Exception\IOException;
use Symfony\Component\Filesystem\Filesystem;

class FileController extends BaseController {
    /**
     * Uploads files from the `files` field in the request  
     * to the `WRITEPATH . 'storage'` directory.
     */
    public function upload() {
        $files = $this->request->getFiles('files');

        // TODO: Ensure files are not overwritten.
        foreach ($files as $file) $file->move(WRITEPATH . 'storage');

        // If it's a JSON request, return a JSON response.
        return $this->response->setJSON(["status" => "success"]);
    }

    public function delete() {
        $path = join('/', func_get_args());
        $absPath = Storage::getStoragePath($path);
        $fs = new Filesystem();

        if (!$fs->exists($absPath)) {
            $this->response->setStatusCode(404);
            return $this->response->setJSON(['message' => "$path does not exist"]);
        }

        try {
            $fs->remove($absPath);
            return $this->response->setJSON(['message' => "Deleted $path"]);
        } catch(IOException $e) {
            $this->response->setStatusCode(500);
            return $this->response->setJSON(['message' => $e->getMessage()]);
        }
    }
}