<?php
namespace AppBundle\Model;


interface MobileContentfulInterface
{
    /**
     * @return string
     */
    public function getMobileContent();

    /**
     * @param string
     * @return $this
     */
    public function setMobileContent($content);
}