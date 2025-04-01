<?php
namespace Application\FOS\CommentBundle\Entity;

use Application\Sonata\MediaBundle\Entity\Media;
use Application\Sonata\UserBundle\Entity\User;
use FOS\CommentBundle\Entity\Comment as BaseComment;
use FOS\CommentBundle\Model\CommentInterface;
use Symfony\Component\HttpFoundation\File\UploadedFile;

class Comment extends BaseComment
{
    /**
     * @var string
     */
    public function __construct()
    {
        parent::__construct();

        $this->setState(CommentInterface::STATE_PENDING);
    }

    /** @var string */
    private $subject;

    /** @var Media */
    private $file;

    /** @var UploadedFile */
    private $binaryContent;

    /**
     * @var User
     */
    private $author;

    /**
     * @return User
     */
    public function getAuthor()
    {
        return $this->author;
    }

    /**
     * @param User $author
     *
     * @return $this
     */
    public function setAuthor($author)
    {
        $this->author = $author;

        return $this;
    }

    /**
     * @return string
     */
    public function getSubject()
    {
        return $this->subject;
    }

    /**
     * @param string $subject
     *
     * @return Comment
     */
    public function setSubject($subject)
    {
        $this->subject = $subject;

        return $this;
    }

    /**
     * Returns comment state list
     *
     * @return array
     */
    public static function getStateList()
    {
        return array(
            CommentInterface::STATE_VISIBLE => 'видимый',
            CommentInterface::STATE_DELETED => 'удалён',
            CommentInterface::STATE_PENDING => 'модерация',
//            CommentInterface::STATE_SPAM => 'спам',
        );
    }

    /**
     * Returns comment state label
     *
     * @return integer|null
     */
    public function getStateLabel()
    {
        $list = self::getStateList();

        return isset($list[$this->getState()]) ? $list[$this->getState()] : null;
    }


    public function getAuthorName()
    {
        /** @var User $author */
        $author = $this->getAuthor();

        if (!$author instanceof User) {
            return 'Аноним';
        }

        return $author->getFullname();
    }

    /**
     * @return Media
     */
    public function getFile()
    {
        return $this->file;
    }

    /**
     * @param Media $file
     *
     * @return Comment
     */
    public function setFile($file)
    {
        $this->file = $file;

        return $this;
    }

    /**
     * @return UploadedFile
     */
    public function getBinaryContent()
    {
        return $this->binaryContent;
    }

    /**
     * @param mixed $binaryContent
     *
     * @return Comment
     */
    public function setBinaryContent($binaryContent)
    {
        $this->binaryContent = $binaryContent;

        return $this;
    }

    public function __toString()
    {
        return 'Комментарий №'.$this->getId();
    }
}
