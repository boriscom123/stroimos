<?php
namespace Application\Sonata\MediaBundle\Thumbnail;

use Liip\ImagineBundle\Templating\Helper\ImagineHelper;
use Sonata\MediaBundle\Model\MediaInterface;
use Sonata\MediaBundle\Provider\MediaProviderInterface;
use Sonata\MediaBundle\Thumbnail\ThumbnailInterface;

class LiipImagineThumbnail implements ThumbnailInterface
{
    /** @var ImagineHelper */
    private $helper;

    /**
     * @param ImagineHelper $helper
     */
    public function __construct(ImagineHelper $helper)
    {
        $this->helper = $helper;
    }


    public function generatePublicUrl(MediaProviderInterface $provider, MediaInterface $media, $format)
    {
        $path = $provider->getReferenceImage($media);

        if ($format === 'reference') {
            return $path;
        }

        $path = $this->helper->filter($path, $format);

        return $path;
    }

    /**
     * @param \Sonata\MediaBundle\Provider\MediaProviderInterface $provider
     * @param \Sonata\MediaBundle\Model\MediaInterface $media
     * @param string $format
     *
     * @return string
     */
    public function generatePrivateUrl(MediaProviderInterface $provider, MediaInterface $media, $format)
    {
        if ($format !== 'reference') {
            throw new \RuntimeException('No private url for LiipImagineThumbnail');
        }

        $path = $provider->getReferenceImage($media);

        return $path;
    }

    /**
     * @param \Sonata\MediaBundle\Provider\MediaProviderInterface $provider
     * @param \Sonata\MediaBundle\Model\MediaInterface $media
     */
    public function generate(MediaProviderInterface $provider, MediaInterface $media)
    {
        // nothing to generate, as generated on demand
    }

    /**
     * @param \Sonata\MediaBundle\Provider\MediaProviderInterface $provider
     * @param \Sonata\MediaBundle\Model\MediaInterface $media
     */
    public function delete(MediaProviderInterface $provider, MediaInterface $media)
    {
        // feature not available
    }
}
