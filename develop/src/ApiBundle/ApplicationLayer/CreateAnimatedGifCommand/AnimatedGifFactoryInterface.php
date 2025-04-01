<?php

namespace ApiBundle\ApplicationLayer\CreateAnimatedGifCommand;

use Imagick;
use Sonata\MediaBundle\Model\Media;

interface AnimatedGifFactoryInterface
{
    /**
     * @param Media[] $medias
     * @return Imagick
     */
    public function create($medias);
}