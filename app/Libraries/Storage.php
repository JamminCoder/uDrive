<?php

namespace App\Libraries;

use App\Libraries\FileSystem\DirItem;
use App\Libraries\FileSystem\FileItem;

class Storage {
    static $root = WRITEPATH . "storage";
    
    public static function ls(string $relativePath='/') {
        $targetDirPath = self::getStoragePath($relativePath);
        if (!is_dir($targetDirPath)) return;

        // ignore `.` and `..` listings
        $contents = array_diff(scandir($targetDirPath), ['.', '..']);
        
        $results = [];
        foreach ($contents as $entry) {
            $filePath = "$targetDirPath/$entry";
            if (is_file($filePath)) {
                $results[] = new FileItem($filePath);
                continue;
            }

            $results[] = new DirItem($filePath);
        }
        return $results;
    }

    public static function getStoragePath($relativePath) {
        $storagePath = rtrim(self::$root . "/$relativePath", '/');
        return $storagePath;
    }
}