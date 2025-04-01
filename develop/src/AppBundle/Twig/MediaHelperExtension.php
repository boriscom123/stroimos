<?php
namespace AppBundle\Twig;

use Sonata\MediaBundle\Model\MediaInterface;
use Symfony\Component\DependencyInjection\ContainerAwareTrait;

class MediaHelperExtension extends \Twig_Extension
{
    use ContainerAwareTrait;

    protected $videoProviders = [
        'sonata.media.provider.youtube' => 'youtube'
    ];

    public function getName()
    {
        return 'media_helper';
    }

    public function getFunctions()
    {
        return [
            new \Twig_SimpleFunction('video_type', [$this,'getVideoType']),
            new \Twig_SimpleFunction('video_length', [$this,'getVideoLength'])
        ];
    }

    public function getVideoType($media)
    {
        $media = $this->getMedia($media);

        if (!$media) {
            return '';
        }

        $provider = $media->getProviderName();

        return isset($this->videoProviders[$provider]) ? $this->videoProviders[$provider] : '';
    }

    /**
     * @param mixed $media
     *
     * @return null|\Sonata\MediaBundle\Model\MediaInterface
     */
    private function getMedia($media)
    {
        if (!$media instanceof MediaInterface && strlen($media) > 0) {
            $media = $this->container->get('sonata.media.manager.media')->findOneBy(array(
                'id' => $media
            ));
        }

        if (!$media instanceof MediaInterface) {
            return false;
        }

        if ($media->getProviderStatus() !== MediaInterface::STATUS_OK) {
            return false;
        }

        return $media;
    }

    public function getVideoLength($media)
    {
        $media = $this->getMedia($media);

        if (!$media) {
            return '';
        }

        return $media->getMetadataValue('length', '');
    }
}