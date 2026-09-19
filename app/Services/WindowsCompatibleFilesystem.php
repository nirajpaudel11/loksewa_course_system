<?php

namespace App\Services;

use Illuminate\Filesystem\Filesystem as BaseFilesystem;
use Throwable;

class WindowsCompatibleFilesystem extends BaseFilesystem
{
    /**
     * Write the contents of a file, replacing it atomically if possible,
     * with graceful fallback for Windows file locking and permission issues.
     *
     * @param  string  $path
     * @param  string  $content
     * @param  int|null  $mode
     * @return void
     */
    public function replace($path, $content, $mode = null)
    {
        $resolvedPath = realpath($path) ?: $path;
        $dir = dirname($resolvedPath);

        if (! is_dir($dir)) {
            @mkdir($dir, 0777, true);
        }

        $tempPath = tempnam($dir, basename($resolvedPath));

        if (! is_null($mode)) {
            @chmod($tempPath, $mode);
        } else {
            @chmod($tempPath, 0777 - umask());
        }

        file_put_contents($tempPath, $content);

        try {
            if (DIRECTORY_SEPARATOR === '\\' && file_exists($resolvedPath)) {
                @unlink($resolvedPath);
            }

            if (! @rename($tempPath, $resolvedPath)) {
                if (! @copy($tempPath, $resolvedPath)) {
                    file_put_contents($resolvedPath, $content, LOCK_EX);
                }
                @unlink($tempPath);
            }
        } catch (Throwable $e) {
            file_put_contents($resolvedPath, $content, LOCK_EX);
            @unlink($tempPath);
        }
    }
}
