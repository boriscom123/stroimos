<?php

namespace ApiBundle\ApplicationLayer\ChangePostPriorityCommand;

use Symfony\Component\Validator\Constraints as Assert;

class ChangePostPriorityCommandDto
{
    /**
     * @Assert\NotBlank
     * @Assert\Type(type="string")
     *
     * @var string
     */
    protected $postId;

    /**
     * @Assert\NotBlank
     * @Assert\Type(type="int")
     *
     * @var int
     */
    protected $priority;

    /**
     * ChangePostPriorityCommandDto constructor.
     * @param string $postId
     * @param int $priority
     */
    public function __construct($postId, $priority)
    {
        $this->postId = $postId;
        $this->priority = $priority;
    }

    public static function createFromArray(array $values)
    {
        $self = new self();

        $self->postId = isset($values['postId']) ? $values['postId'] : null;
        $self->priority= isset($values['priority']) ? $values['priority'] : null;

        return $self;
    }

    /**
     * @return string
     */
    public function getPostId()
    {
        return $this->postId;
    }

    /**
     * @return int
     */
    public function getPriority()
    {
        return $this->priority;
    }
}
