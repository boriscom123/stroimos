<?php

namespace AppBundle\Admin\MediaProvider;

use FFMpeg\Exception\RuntimeException as FFMpegRuntimeException;
use FFMpeg\FFProbe;
use Sonata\CoreBundle\Model\Metadata;
use Sonata\MediaBundle\Provider\FileProvider;
use Sonata\AdminBundle\Validator\ErrorElement;
use Sonata\MediaBundle\Model\MediaInterface;
use Symfony\Component\HttpFoundation\File\File;

class VideoProvider extends FileProvider
{
    /**
     * {@inheritdoc}
     */
    public function getProviderMetadata()
    {
        return new Metadata($this->getName(), $this->getName().'.description', null, 'SonataMediaBundle', array('class' => 'fa fa-video-camera'));
    }

    public function validate(ErrorElement $errorElement, MediaInterface $media)
    {
        $this->allowedExtensions = array_merge($this->allowedExtensions, array('mp4', 'webm'));
        $this->allowedMimeTypes = array_merge($this->allowedMimeTypes, array('video/mp4', 'video/webm'));

        parent::validate($errorElement, $media);
    }

    public function updateMetadata(MediaInterface $media, $force = true)
    {
        try {
            $metadata = $this->getMetadata($media);
            foreach ($metadata as $key => $value) {
                $media->setMetadataValue($key, $value);
            }

            $media->setHeight($metadata['height']);
            $media->setWidth($metadata['width']);
            $media->setLength($metadata['duration']);
        } catch (FFMpegRuntimeException $e) {
        }
    }

    protected function doTransform(MediaInterface $media)
    {
        parent::doTransform($media);

        $this->updateMetadata($media);
    }

    private function getMetadata(MediaInterface $media)
    {
        /** @var File $binaryContent */
        $binaryContent = $media->getBinaryContent();

        $pathname = $binaryContent->getRealPath();

        $streams = FFProbe::create()->streams($pathname);
        $video = $streams->videos()->first();
        $audio = $streams->audios()->first();

        return [
            'size' => $binaryContent->getSize(),
            'width' => $video ? $video->get('width') : 0,
            'height' => $video ? $video->get('height') : 0,
            'duration' => round($video ? $video->get('duration') : $audio->get('duration')),
        ];
    }
}
