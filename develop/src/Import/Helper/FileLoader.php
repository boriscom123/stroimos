<?php

namespace Import\Helper;

use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\File\Exception\UploadException;

class FileLoader
{
    private $cacheDir;
    private $baseUrl;

    public function __construct($cacheDir, $baseUrl)
    {
        $this->cacheDir = rtrim($cacheDir, '/');
        $this->baseUrl = rtrim($baseUrl, '/');
    }

    protected function getFullUrl($url)
    {
        return $this->baseUrl . $url;
    }

    public function getLocalPathForUrl($url)
    {
        $urlInfo = parse_url($url);
        $pathInfo = pathinfo($urlInfo['path']);

        $cacheDir = "{$this->cacheDir}/" . trim($pathInfo['dirname'], '/');

        if (!is_dir($cacheDir)) {
            if (false === @mkdir($cacheDir, 0777, true) && !is_dir($cacheDir)) {
                throw new FileException(sprintf('Unable to create the "%s" directory', $cacheDir));
            }
        } elseif (!is_writable($cacheDir)) {
            throw new FileException(sprintf('Unable to write in the "%s" directory', $cacheDir));
        }

        return "$cacheDir/{$pathInfo['basename']}";
    }

    public function downloadFile($url, $saveTo)
    {
        set_error_handler(function ($errno, $errst) {
            restore_error_handler();
            throw new UploadException($errst, $errno);
        }, E_ALL);

        echo '.';
        file_put_contents($saveTo,
            file_get_contents($url)
        );
        echo "\x08";

        restore_error_handler();
    }

    public function loadFile($url)
    {
        $url = $this->getFullUrl($url);
        $localPath = $this->getLocalPathForUrl($url);

        if (!file_exists($localPath)) {
            $this->downloadFile($url, $localPath);
        }

        return $localPath;
    }
}