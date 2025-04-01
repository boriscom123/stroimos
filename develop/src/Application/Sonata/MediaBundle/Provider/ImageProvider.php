<?php
namespace Application\Sonata\MediaBundle\Provider;

use Sonata\MediaBundle\Model\MediaInterface;
use Sonata\MediaBundle\Provider\ImageProvider as BaseImageProvider;

class ImageProvider extends BaseImageProvider
{
    public function generatePublicUrl(MediaInterface $media, $format)
    {
        if ($format === 'reference') {
            return $this->getCdn()->getPath($this->getReferenceImage($media), $media->getCdnIsFlushable());
        }

        try {
            $publicUrl = $this->thumbnail->generatePublicUrl($this, $media, $format);
        } catch (\Exception $e) {
            $publicUrl = '';
        }

        return $publicUrl;
    }
}
