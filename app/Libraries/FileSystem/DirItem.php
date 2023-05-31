<?php

namespace App\Libraries\FileSystem;
use App\Libraries\FileSystem\UploadedItem;

class DirItem extends UploadedItem {
    public int $size;
    public int $fileCount;
    
    public function __construct($path) {
        parent::__construct($path);

        // -2 to discount the . and .. listings
        $this->fileCount = count(scandir($path)) - 2;
        $this->size = $this->getDirSize($path);
    }

    /**
     * Recursively get the size of all of the files and directories in $path
     * @param string $path
     * @return int $size
     */
    private function getDirSize($path) {
        $size = 0;
        foreach (scandir($path) as $entry) {
            if ($entry == '.' || $entry == '..') continue;
            $entryPath = "$path/$entry";
            if (is_dir($entryPath)) {
                $size += $this->getDirSize($entryPath);
                continue;
            }
            $size += filesize($entryPath);
        }
        return $size;
    }
}