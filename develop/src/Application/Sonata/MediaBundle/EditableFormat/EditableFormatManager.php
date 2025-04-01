<?php
namespace Application\Sonata\MediaBundle\EditableFormat;

use Imagine\Filter\Advanced\Grayscale;
use Imagine\Image\Box;
use Imagine\Image\ImageInterface;
use Imagine\Image\Point;
use Imagine\Imagick\Image;
use Imagine\Imagick\Imagine;
use Liip\ImagineBundle\Imagine\Filter\Loader\CropFilterLoader;
use Liip\ImagineBundle\Imagine\Filter\Loader\UpscaleFilterLoader;
use Sonata\MediaBundle\Model\MediaInterface;
use Sonata\MediaBundle\Provider\MediaProviderInterface;

class EditableFormatManager
{
    /**
     * @var string
     */
    private $maskDir;

    /**
     * @var string
     */
    private $baseUrl;

    /**
     * EditableFormatManager constructor.
     * @param $rootDir string
     * @param $baseUrl string
     */
    public function __construct($rootDir, $baseUrl)
    {
        $this->maskDir = $rootDir . '/Resources/data/overlay/';
        $this->baseUrl = $baseUrl;
    }

    /**
     * @param MediaProviderInterface $provider
     * @param MediaInterface $media
     * @param $format
     * @return string
     */
    protected function generateEditedFormatPath(MediaProviderInterface $provider, MediaInterface $media, $format)
    {
        $pathinfo = pathinfo($media->getProviderReference());
        return sprintf('%s/%s-%s.%s',
            $provider->generatePath($media),
            $pathinfo['filename'],
            $format,
            $pathinfo['extension']
        );
    }

    /**
     * @param MediaProviderInterface $provider
     * @param MediaInterface $media
     * @param $format
     * @return null|string
     */
    public function getEditedFormatPath(MediaProviderInterface $provider, MediaInterface $media, $format)
    {
        $editedPath = $this->generateEditedFormatPath($provider, $media, $format);

        if (!$provider->getFilesystem()->has($editedPath)) {
            return null;
        }

        return $this->baseUrl . $provider->getCdnPath($editedPath, $media->getCdnIsFlushable());
    }

    /**
     * @param MediaProviderInterface $provider
     * @param MediaInterface $media
     * @param $editableFormat
     * @param $crop
     * @param $mask
     */
    public function editFormat(MediaProviderInterface $provider, MediaInterface $media, $editableFormat, $crop, $mask)
    {
        $imagine = new Imagine();
        $image = $imagine->load($provider->getReferenceFile($media)->getContent());

        $image = (new CropFilterLoader())
            ->load($image, [
                'start' => [$crop['x'], $crop['y']],
                'size' => [$crop['width'], $crop['height']],
            ]);

        $image = (new UpscaleFilterLoader())
            ->load($image, [
                'min' => [$editableFormat['width'], $editableFormat['height']]
            ]);

        /**
         * @var $image ImageInterface
         */
        $image = $image->thumbnail(new Box($editableFormat['width'], $editableFormat['height']), Image::THUMBNAIL_OUTBOUND);

        if($editableFormat['format'] === 'person_thumb70') {
/*            Убран ЧБ фильтр*/
/*            $filter = new Grayscale();
            $image = $filter->apply($image);*/
            $mask = 'person_quote';
        }

        if(!empty($mask)) {
            $maskImagePath = sprintf('%s%s.png', $this->maskDir, $mask);
            if(file_exists($maskImagePath)) {
                $maskImage = $imagine->open($maskImagePath);
                $image = $image->paste($maskImage, new Point(0,0));
            }
        }

        $content = $image->get($media->getExtension(), array('quality' => $editableFormat['quality']));

        $editedImage = $provider->getFilesystem()->get(
            $this->generateEditedFormatPath($provider, $media, $editableFormat['format']),
            true
        );
        $editedImage->setContent($content);
    }
}
