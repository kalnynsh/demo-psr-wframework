<?php

namespace App\Service\FileService;

use RuntimeException;

class FileManager
{
    public function exists(string $path): bool
    {
        return \file_exists($path);
    }

    public function delete(string $path): void
    {
        if (! \file_exists($path)) {
            throw new \RuntimeException('Given undifined path: ' . $path);
        }

        if (\is_dir($path)) {
            foreach (scandir($path, SCANDIR_SORT_ASCENDING) as $dirItem) {
                if ($dirItem === '.' || $dirItem === '..') {
                    continue;
                }

                $this->delete($path . DIRECTORY_SEPARATOR . $dirItem);
            }

            if (! rmdir($path)) {
                throw new \RuntimeException('Unable to delete directory: ' . $path);
            }
        }

        if (\is_file($path)) {
            if (! \unlink($path)) {
                throw new \RuntimeException('Unable to delete file: ' . $path);
            }
        }
    }
}
