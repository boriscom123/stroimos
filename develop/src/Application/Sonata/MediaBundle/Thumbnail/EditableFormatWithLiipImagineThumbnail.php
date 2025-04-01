<?php
namespace Application\Sonata\MediaBundle\Thumbnail;

use Application\Sonata\MediaBundle\EditableFormat\EditableFormatManager;
use Liip\ImagineBundle\Templating\Helper\ImagineHelper;
use Sonata\MediaBundle\Model\MediaInterface;
use Sonata\MediaBundle\Provider\MediaProviderInterface;
use Sonata\MediaBundle\Thumbnail\ThumbnailInterface;

class EditableFormatWithLiipImagineThumbnail implements ThumbnailInterface
{
    /** @var ImagineHelper */
    private $helper;
    /**
     * @var EditableFormatManager
     */
    private $editableFormatManager;

    /**
     * @param ImagineHelper $helper
     * @param EditableFormatManager $editableFormatManager
     */
    public function __construct(ImagineHelper $helper, EditableFormatManager $editableFormatManager)
    {
        $this->helper = $helper;
        $this->editableFormatManager = $editableFormatManager;
    }


    public function generatePublicUrl(MediaProviderInterface $provider, MediaInterface $media, $format)
    {
        if ('reference' === $format) {
            return $provider->getReferenceImage($media);
        }

        if ($path = $this->editableFormatManager->getEditedFormatPath($provider, $media, $format)) {
            return $path;
        }

        return $this->helper->filter($provider->getReferenceImage($media), $format);
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
        if ('reference' === $format) {
            return $provider->getReferenceImage($media);
        }

        throw new \RuntimeException('No private url for LiipImagineThumbnail');
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
