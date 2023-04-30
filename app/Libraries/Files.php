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


class Files {
    static $storagePath = WRITEPATH . "storage";
    
    public static function ls(string $relativeStoragePath='/') {
        $storagePath = self::getStoragePath($relativeStoragePath);
        $contents = array_diff(scandir($storagePath), ['.', '..']);
        $results = [];
        foreach ($contents as $entry) {
            $filePath = "$storagePath/$entry";
            $results[] = new FileEntry($filePath);
        }
        return $results;
    }

    public static function getStoragePath($relativeStoragePath) {
        if ($relativeStoragePath != '/')
        $relativeStoragePath = trim($relativeStoragePath, '/');

        $storagePath = rtrim(self::$storagePath . "/$relativeStoragePath", '/');
        return $storagePath;
    }
}


// public static function dirTree(string $root) {
//     $current = array_diff(scandir($root, SCANDIR_SORT_DESCENDING), ['.', '..']);
//
//     $result = [$root => []];
//
//     foreach ($current as $entry) {
//         if (is_dir($root . '/' . $entry)) {
//             $result[$root][$entry] = self::dirTree($root . '/' . $entry);
//         } else {
//             $result[$root][] = $entry;
//         }
//     }
//
//     return $result;
// }
//
// public static function renderFileTree(array $tree, $indent=0) {
//     foreach ($tree as $path => $value) {
//         if (is_array($value)) {
//             echo 
//             "<div style='padding-left: {$indent}rem'>" . 
//                 (!is_dir($path) ? $path: "") . "" .
//             "</div>";
//             self::renderFileTree($value, $indent + 0.5);
//         } else {
//             echo 
//             "<div style='padding-left: {$indent}rem'>
//                 $value<br>
//             </div>";
//         };
//         
//     }
// }
