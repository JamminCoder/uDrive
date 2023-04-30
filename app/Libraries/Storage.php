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
        $storagePath = self::getStoragePath($relativePath);
        error_log($storagePath);
        $contents = array_diff(scandir($storagePath), ['.', '..']);
        $results = [];
        foreach ($contents as $entry) {
            $filePath = "$storagePath/$entry";
            $results[] = new FileEntry($filePath);
        }
        return $results;
    }

    public static function getStoragePath($relativePath) {
        $storagePath = rtrim(self::$root . "/$relativePath", '/');
        return $storagePath;
    }
}