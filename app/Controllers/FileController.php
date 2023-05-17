<?php

namespace App\Controllers;
use App\Controllers\BaseController;
use App\Libraries\Storage;
use Symfony\Component\Filesystem\Exception\IOException;
use Symfony\Component\Filesystem\Filesystem;

class FileController extends BaseController {
    /**
     * Uploads files from the `files[]` field in the request  
     * to the storage directory.
     */
    public function upload() {
        $path = join('/', func_get_args());
        $absPath = Storage::getStoragePath($path);
        if (!is_dir($absPath)) {
            return $this->response->setStatusCode(500, 'Path does not exist.');
        }
        
        $requestFiles = $this->request->getFiles();

        // Did the user upload 1 or multiple files?
        $files = isset($requestFiles['files']) 
        ? $requestFiles['files'] 
        : $requestFiles;

        // TODO: Ensure files are not overwritten.
        foreach ($files as $file) {
            $file->move();
        }

        return $this->response->setJSON(["status" => "success"]);
    }

    public function create() {
        $path = join('/', func_get_args());
        $absPath = Storage::getStoragePath($path);

        $fs = new Filesystem();

        if ($fs->exists($absPath)) 
            return $this->response
                ->setJSON(['message' => 'File already exists'])
                ->setStatusCode(500, 'File already exists');
        
        $fs->touch($absPath);

        return $this->response->setJSON(['message' => 'File successfully created']);
    }

    public function delete() {
        $path = join('/', func_get_args());
        $absPath = Storage::getStoragePath($path);
        $fs = new Filesystem();

        if ($absPath === Storage::$root) {
            $this->response->setStatusCode(403);
            return $this->response->setJSON(['message' => "Cannot delete root directory"]);
        }

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