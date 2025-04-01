<?php
namespace Amg\DataCore\Model\Commentable;

use Doctrine\ORM\Mapping as ORM;

trait CommentableTrait
{
    /**
     * @var bool
     * @ORM\Column(type="boolean")
     */
    private $isCommentsOpen = false;

    /**
     * @return boolean
     */
    public function isCommentsOpen()
    {
        return $this->isCommentsOpen;
    }

    /**
     * @param boolean $isCommentsOpen
     *
     * @return CommentableInterface
     */
    public function setIsCommentsOpen($isCommentsOpen)
    {
        $this->isCommentsOpen = $isCommentsOpen;

        return $this;
    }
}
