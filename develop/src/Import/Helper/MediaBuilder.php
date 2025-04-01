<?php
namespace Import\Helper;

use Application\Sonata\MediaBundle\Entity\Media;
use Doctrine\ORM\EntityManager;
use Sonata\MediaBundle\Entity\MediaManager;

class MediaBuilder
{
    /**
     * @var MediaManager
     */
    private $mediaManager;
    /**
     * @var EntityManager
     */
    private $manager;
    /**
     * @var FileLoader
     */
    private $fileLoader;
    /**
     * @var string
     */
    private $fakeImage;
    /**
     * @var string
     */
    private $fakeVideo;

    public function __construct(EntityManager $manager, MediaManager $mediaManager, FileLoader $fileLoader = null, $fakeImage = null, $fakeVideo = null)
    {
        $this->mediaManager = $mediaManager;
        $this->manager = $manager;
        $this->fileLoader = $fileLoader;
        $this->fakeImage = $fakeImage;
        $this->fakeVideo = $fakeVideo;
    }

    public function createMediaFromUrl($url, $context = 'main_image', $provider = 'sonata.media.provider.image')
    {
        if ('sonata.media.provider.image' === $provider && $this->fakeImage) {
            return $this->createMedia($this->fakeImage, $context, $provider);
        }
        if ('sonata.media.provider.video' === $provider && $this->fakeVideo) {
            return $this->createMedia($this->fakeVideo, $context, $provider);
        }
        $file = $this->fileLoader->loadFile($url);
        return $this->createMedia($file, $context, $provider);
    }

    public function createMedia($file, $context = 'main_image', $provider = 'sonata.media.provider.image')
    {
        /** @var Media $media */
        $media = new Media();

        $media->setBinaryContent($file);
        $media->setProviderName($provider);
        $media->setEnabled(true);
        $media->setContext($context);

        $this->manager->persist($media);

        return $media;
    }
}
