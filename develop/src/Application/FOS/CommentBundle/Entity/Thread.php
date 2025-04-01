<?php
namespace Application\FOS\CommentBundle\Entity;

use FOS\CommentBundle\Entity\Thread as BaseThread;

class Thread extends BaseThread
{
    /**
     * @var Comment[]
     */
    private $comments;

    /**
     * @param bool $isCommentable
     */
    public function setIsCommentable($isCommentable)
    {
        $this->setCommentable($isCommentable);
    }

    /**
     * @return Comment[]
     */
    public function getComments()
    {
        return $this->comments;
    }

    /**
     * @param Comment[] $comments
     *
     * @return Thread
     */
    public function setComments($comments)
    {
        $this->comments = $comments;

        return $this;
    }

    public function __toString()
    {
        return 'Тема '.$this->getId();
    }
}
