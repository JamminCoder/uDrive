<?php

namespace App\Libraries\FileSystem;
use App\Libraries\FileSystem\UploadedItem;

class FileItem extends UploadedItem {
    public string $mime;
    public int $size;
    public string $extension;

    public function __construct($path) {
        parent::__construct($path);

        $this->mime = mime_content_type($path);
        $this->extension = pathinfo($path, PATHINFO_EXTENSION);
        $this->size = filesize($path);
    }
}