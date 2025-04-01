<?php
namespace AppBundle\Model;

use Amg\Bundle\TagBundle\Entity\Tag;

interface ShowLastNewsInterface
{
    /**
     * @return boolean
     */
    public function getShowLastNews();

    /**
     * @return Tag[]
     */
    public function getLastNewsTags();
}