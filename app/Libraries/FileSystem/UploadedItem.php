<?php

namespace App\Libraries\FileSystem;
use App\Libraries\Storage;
use Symfony\Component\Filesystem\Path;


class UploadedItem {
    public const DIR = 'DIR';
    public const FILE = 'FILE';

    public string $path;
    public string $name;
    public string $storagePath;
    public string $type;
    public bool $isDir = false;

    public function __construct($path) {
        $path = Path::canonicalize($path);

        // Don't allow paths from outside the storage root
        if (!str_starts_with($path, Storage::$root)) {
            throw new \Exception("Path must be inside storage root");
        }

        $this->path = $path;

        // Extract the name from the path
        $nameStart = strrpos($path, DIRECTORY_SEPARATOR, -1) + 1;
        $this->name = substr($path, $nameStart);
        $this->storagePath = $this->getRelativeStoragePath();

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

    public function getRelativeStoragePath() {
        $pathPieces = explode('/storage/', $this->path);
        if (!count($pathPieces) > 1) return $pathPieces[0];

        $result = '';
        $storagePaths = array_slice($pathPieces, 1);
        foreach ($storagePaths as $path) {
            $result .= $path . '/';
        }
        return rtrim($result, '/');
    }
}
