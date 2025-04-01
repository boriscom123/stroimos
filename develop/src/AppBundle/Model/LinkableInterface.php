<?php
namespace AppBundle\Model;


interface LinkableInterface
{
    /**
     * @return string
     */
    public function getLink();

    /**
     * @param string $link
     * @return $this
     */
    public function setLink($link);

    /**
     * @return bool
     */
    public function isTargetBlank();

    /**
     * @param bool $isTargetBlank
     * @return $this
     */
    public function setIsTargetBlank($isTargetBlank);
}