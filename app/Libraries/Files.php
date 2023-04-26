<?php

namespace App\Libraries;

use PhpParser\Node\Stmt\Continue_;

class Files {
    public static function dirTree(string $root) {
        $current = array_diff(scandir($root, SCANDIR_SORT_DESCENDING), ['.', '..']);

        $result = [$root => []];

        foreach ($current as $entry) {
            if (is_dir($root . '/' . $entry)) {
                $result[$root][$entry] = self::dirTree($root . '/' . $entry);
            } else {
                $result[$root][] = $entry;
            }
        }

        return $result;
    }

    public static function renderFileTree(array $tree, $indent=0) {
        foreach ($tree as $path => $value) {
            if (is_array($value)) {
                echo 
                "<div style='padding-left: {$indent}rem'>" . 
                    (!is_dir($path) ? $path: "") . "" .
                "</div>";

                self::renderFileTree($value, $indent + 0.5);
            } else {
                echo 
                "<div style='padding-left: {$indent}rem'>
                    $value<br>
                </div>";
            };
            
        }
    }
}