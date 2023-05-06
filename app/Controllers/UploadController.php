<?php

namespace App\Controllers;
use App\Controllers\BaseController;


class UploadController extends BaseController {
    /**
     * Uploads files from the `files` field in the request  
     * to the `WRITEPATH . 'storage'` directory.
     */
    public function upload() {
        $files = $this->request->getFiles('files');

        // TODO: Ensure files are not overwritten.
        foreach ($files as $file) $file->move(WRITEPATH . 'storage');

        // If it came from a page, redirect.
        if (isset($_SERVER['HTTP_REFERER']))
            return redirect()->to($_SERVER['HTTP_REFERER']);

        // If it's a JSON request, return a JSON response.
        else return $this->response->setJSON(["status" => "success"]);
    }
}