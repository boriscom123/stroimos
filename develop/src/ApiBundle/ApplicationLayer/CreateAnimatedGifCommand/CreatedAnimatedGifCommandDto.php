<?php

namespace ApiBundle\ApplicationLayer\CreateAnimatedGifCommand;

use Symfony\Component\Validator\Constraints as Assert;

class CreatedAnimatedGifCommandDto
{
    const ALLOWABLE_IMAGE_COUNT = 5;

    /**
     * @Assert\NotBlank
     * @Assert\Type(type="array")
     */
    protected $mediaIds;

    /**
     * ChangePostPriorityCommandDto constructor.
     * @param string $postId
     * @param int $priority
     */
    public function __construct($mediaIds)
    {
        $this->mediaIds = array_slice($mediaIds, 0, self::ALLOWABLE_IMAGE_COUNT);
    }

    /**
     * @return mixed
     */
    public function getMediaIds()
    {
        return $this->mediaIds;
    }
}
