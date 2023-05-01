<?php

namespace App\Libraries\FileSystem;


class FileSystemItem {
    public const DIR = 'DIR';
    public const FILE = 'FILE';

    public string $path;
    public string $storagePath;
    public string $type;
    public bool $isDir = false;

    public function __construct($path) {
        $this->path = $path;
        $this->storagePath = explode('/storage/', $path)[1];
        if (is_dir($path)) {
            $this->type = self::DIR;
            $this->isDir = true;
        } else {
            $this->type = self::FILE;
        }
    }

    public function __toString(): string {
        return $this->path;
    }

    public function __debugInfo(): array {
        return [
            "path" => $this->path,
            "type" => $this->type
        ];
    }

    public function __serialize(): array
    {
        return [
            "path" => $this->path,
            "type" => $this->type
        ];
    }
}
