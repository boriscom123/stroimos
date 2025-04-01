<?php

namespace ApiBundle\PresentationLayer\View\AnimatedGif;

use Application\Sonata\MediaBundle\Entity\Media;
use Sonata\MediaBundle\Provider\ImageProvider;
use Symfony\Component\HttpFoundation\RequestStack;

class ApiCreationResult
{
    /**
     * @var ImageProvider
     */
    private $imageProvider;
    /**
     * @var RequestStack
     */
    private $requestStack;

    public function __construct(
        ImageProvider $imageProvider,
        RequestStack $requestStack
    ) {
        $this->imageProvider = $imageProvider;
        $this->requestStack = $requestStack;
    }

    public function __invoke(Media $animatedGifMedia)
    {
        $request = $this->requestStack->getCurrentRequest();
        $publicUrl = $request->getSchemeAndHttpHost() . $this->imageProvider->generatePublicUrl($animatedGifMedia, 'reference');
        return [
            'id' => $animatedGifMedia->getId(),
            'url' => $publicUrl
        ];
    }

}