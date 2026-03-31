<?php

namespace App\Support;

use Illuminate\Filesystem\Filesystem;
use RuntimeException;

class SafeFilesystem extends Filesystem
{
    public function replace($path, $content, $mode = null): void
    {
        $directory = dirname($path);

        if (! is_dir($directory)) {
            mkdir($directory, 0777, true);
        }

        $written = file_put_contents($path, $content, LOCK_EX);

        if ($written === false) {
            throw new RuntimeException('Unable to write file at path: '.$path);
        }

        if ($mode !== null) {
            chmod($path, $mode);
        }
    }
}
