<?php

namespace AppBundle\Entity\NewsletterItem;

use AppBundle\Entity\Newsletter;
use AppBundle\Entity\Post;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity()
 * @ORM\Table(
 *     name="newsletter_posts"
 * )
 */
class PostNewsletter extends BaseItem
{
    /**
     * @var Newsletter
     *
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Newsletter", inversedBy="posts")
     * @ORM\JoinColumn(name="newsletter_id", referencedColumnName="id", onDelete="CASCADE", nullable=false)
     */
    protected $newsletter;

    /**
     * @var Post
     *
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Post")
     * @ORM\JoinColumn(onDelete="CASCADE", nullable=false)
     */
    protected $post;

    /**
     * @return Post
     */
    public function getPost()
    {
        return $this->post;
    }

    /**
     * @param Post $post
     * @return $this
     */
    public function setPost($post)
    {
        $this->post = $post;

        return $this;
    }

    /**
     * @inheritdoc
     */
    public function __toString()
    {
        return $this->getPost()->__toString();
    }
}
