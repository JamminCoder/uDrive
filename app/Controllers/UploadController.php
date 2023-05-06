<?php

namespace App\Controllers;
use App\Controllers\BaseController;
use CodeIgniter\HTTP\Message;
use CodeIgniter\HTTP\UserAgent;


class UploadController extends BaseController {
    /**
     * Uploads files from the `files` field in the request  
     * to the `WRITEPATH . 'storage'` directory.
     */
    public function upload() {
        $files = $this->request->getFiles('files');

        // TODO: Ensure files are not overwritten.
        foreach ($files as $file) $file->move(WRITEPATH . 'storage');

        // If it came from a page, redirect back to page.
        if ($referer = $this->request->header('Referrer')){
            $this->response->setStatusCode(301);
            $this->response->setHeader('Location', $referer->getValue());
            return $this->response;
        }

        // If it's a JSON request, return a JSON response.
        else return $this->response->setJSON(["status" => "success"]);
    }
}