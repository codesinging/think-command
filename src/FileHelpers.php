<?php
/**
 * Author: CodeSinging <codesinging@gmail.com>
 * Time: 2019/12/7 09:48
 */

namespace CodeSinging\ThinkCommand;

use CodeSinging\Filesystem\Filesystem;

trait FileHelpers
{
    /**
     * Create a directory.
     *
     * @param string $path
     * @param int    $mode
     * @param bool   $recursive
     */
    protected function makeDirectory($path, $mode = 0755, $recursive = true)
    {
        if (is_dir($path)) {
            $this->warning('The path already exists: ' . $path);
        } else {
            if (mkdir($path, $mode, $recursive)) {
                $this->info('Create directory successfully: ' . $path);
            } else {
                $this->error('Failed to create directory: ' . $path);
            }
        }
    }

    /**
     * Create file from a source file.
     *
     * @param string $src
     * @param string $dst
     * @param array  $replaces
     */
    protected function copy(string $src, string $dst, array $replaces = [])
    {
        if (Filesystem::isFile($src)){
            if (empty($replaces)) {
                if (copy($src, $dst)) {
                    $this->info('Create file successfully: ' . $dst);
                } else {
                    $this->error('Failed to create file: ' . $dst);
                }
            } else {
                $content = file_get_contents($src);
                if (false === $content) {
                    $this->error('Source file does not exists: ' . $src);
                } else {
                    foreach ($replaces as $search => $replace) {
                        $content = str_replace($search, $replace, $content);
                    }
                    if (file_put_contents($dst, $content)) {
                        $this->info('Create file successfully: ' . $dst);
                    } else {
                        $this->error('Failed to create file: ' . $dst);
                    }
                }
            }
        } else {
            $this->warning('File does not exist: '. $src);
        }
    }

    /**
     * Create files from a directory to another.
     *
     * @param string $src
     * @param string $dst
     * @param array  $replaces
     */
    protected function copyFiles(string $src, string $dst, array $replaces = [])
    {
        if (Filesystem::isDirectory($src)){
            $files = Filesystem::allFiles($src);
            foreach ($files as $file) {
                $dstPath = $dst . '/' . $file->getFileName();
                $this->copy($file->getPathName(), $dstPath, $replaces);
            }
        } else {
            $this->warning('Directory does not exist: '. $src);
        }
    }

    /**
     * Copy a directory to another location.
     * @param string $src
     * @param string $dst
     */
    protected function copyDirectory(string $src, string $dst)
    {
        if (Filesystem::isDirectory($src)){
            if (Filesystem::copyDirectory($src, $dst)) {
                $this->info('Publish directory successfully: ' . $dst);
            } else {
                $this->error('Failed to publish directory: ' . $src);
            }
        } else{
            $this->warning('Directory does not exist: '. $src);
        }
    }
}