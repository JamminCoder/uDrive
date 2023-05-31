<?php

namespace App\Libraries;

use App\Libraries\FileSystem\DirItem;
use App\Libraries\FileSystem\FileItem;
use Symfony\Component\Filesystem\Path;

class Storage {
    static $root = WRITEPATH . "storage";
    
    /**
     * @param string $relativePath
     * @return FileItem[] | DirItem[]
     */
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

    public static function getStoragePath(string $relativePath='') {
        $storagePath = rtrim(self::$root . "/$relativePath", '/');
        $storagePath = Path::canonicalize($storagePath);

        // Don't allow users to access files outside of the storage root.
        if (str_starts_with($storagePath, self::$root)) return $storagePath;
        
        // Just return the storage path if the user 
        // tried to get any path outside of the storage root.
        return self::$root;
    }
}