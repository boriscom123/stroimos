<?php

namespace ApiBundle\InfrastructureLayer\Service;

use ApiBundle\ApplicationLayer\CreateAnimatedGifCommand\AnimatedGifFactoryInterface;
use Application\Sonata\MediaBundle\Provider\ImageProvider;
use Imagick;
use Sonata\MediaBundle\Model\Media;

class AnimatedGifFactory implements AnimatedGifFactoryInterface
{
    const TMP_FILE_PREFIX = 'animatedGif';
    const SOURCE_MEDIA_FORMAT = 'reference';
    const CREATION_SETTINGS = [
        'width' => 600,
        'height' => 400,
        'filter' => Imagick::FILTER_UNDEFINED,
        'blur' => 1,
        'bestfit' => true,
        'delay' => 100,
    ];
    /**
     * @var ImageProvider
     */
    private $imageProvider;

    /**
     * @var string
     */
    private $kernelWebDir;

    public function __construct(
        ImageProvider $imageProvider,
        $kernelWebDir
    )
    {
        $this->imageProvider = $imageProvider;
        $this->kernelWebDir = $kernelWebDir;
    }

    /**
     * @param Media[] $medias
     *
     * @return Imagick
     */
    public function create($medias)
    {
        $gif = new Imagick();
        foreach ($medias as $media) {
            $path = $this->imageProvider->generatePublicUrl($media, self::SOURCE_MEDIA_FORMAT);
            $frame = new Imagick();
            $frame->readImage("{$this->kernelWebDir}{$path}");
            $frame->resizeImage(
                self::CREATION_SETTINGS['width'],
                self::CREATION_SETTINGS['height'],
                self::CREATION_SETTINGS['filter'],
                self::CREATION_SETTINGS['blur'],
                self::CREATION_SETTINGS['bestfit']
            );
            $frame->setImageDelay(self::CREATION_SETTINGS['delay']);
            $gif->addImage($frame);
        }

        $tmpFileName = sys_get_temp_dir() . '/' . uniqid(self::TMP_FILE_PREFIX, true) . '.gif';
        $gif->setImageFormat("GIF");
        $gif->writeImages($tmpFileName, true);

        return $gif;
    }
}