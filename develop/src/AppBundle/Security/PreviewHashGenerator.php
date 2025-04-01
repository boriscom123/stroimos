<?php

namespace AppBundle\Security;


class PreviewHashGenerator {

    private $salt;

    public function __construct($salt)
    {
        $this->salt = $salt;
    }

    /**
     * @param string $path
     * @return string
     */
    public function generateHash($path)
    {
        return md5($this->salt . $path . $this->salt);
    }

    /**
     * @param $hash
     * @param $path
     * @return bool
     */
    public function isHashValid($hash, $path)
    {
        return $hash === $this->generateHash($path);
    }
}
