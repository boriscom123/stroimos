<?php
namespace AppBundle\Model;

use AppBundle\Entity\Post;
use AppBundle\Entity\PostAttachment;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

trait AttachmentsTrait
{
    /**
     * @var PostAttachment[]|ArrayCollection
     *
     * @ORM\OneToMany(targetEntity="AppBundle\Entity\PostAttachment", mappedBy="post", cascade={"persist", "remove"})
     * @ORM\OrderBy({"position" = "ASC"})
     */
    protected $attachments;

    /**
     * @param PostAttachment[] $attachments
     *
     * @return Post
     */
    public function setAttachments($attachments)
    {
        $this->attachments = $attachments;

        return $this;
    }

    /**
     * @return PostAttachment[]|ArrayCollection
     */
    public function getAttachments()
    {
        return $this->attachments = $this->attachments ?: new ArrayCollection();
    }

    public function addAttachment(PostAttachment $postAttachment)
    {
        $this->attachments->add($postAttachment);
    }
}
