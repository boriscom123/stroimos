<?php
namespace Import\Gaufrette;

use Gaufrette\Filesystem;

class NoRegisterFilesystem extends Filesystem
{
    public function createFile($key)
    {
        $result = parent::createFile($key);

        $this->fileRegister = [];

        return $result;
    }
}