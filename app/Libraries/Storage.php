<?php

namespace App\Libraries;

class FileEntry {
    public string $path;
    public string $storagePath;
    public bool $is_dir;

    public function __construct($path) {
        $this->path = $path;
        $this->storagePath = explode('/storage/', $path)[1];
        $this->is_dir = is_dir($path);
    }

    public function __toString(): string {
        return $this->path;
    }

    public function __debugInfo(): array {
        return [
            "path" => $this->path,
            "is_dir" => $this->is_dir
        ];
    }

    public function __serialize(): array
    {
        return [
            "path" => $this->path,
            "is_dir" => $this->is_dir
        ];
    }
}


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
            $results[] = new FileEntry($filePath);
        }
        return $results;
    }

    public static function getStoragePath($relativePath) {
        $storagePath = rtrim(self::$root . "/$relativePath", '/');
        return $storagePath;
    }
}