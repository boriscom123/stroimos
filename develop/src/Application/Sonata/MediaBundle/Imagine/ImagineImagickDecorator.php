<?php
namespace Application\Sonata\MediaBundle\Imagine;

use Imagine\Image\AbstractImagine;
use Imagine\Image\BoxInterface;
use Imagine\Image\ImagineInterface;
use Imagine\Image\Metadata\ExifMetadataReader;
use Imagine\Image\Palette\Color\ColorInterface;
use Imagine\Imagick\Imagine;

class ImagineImagickDecorator extends AbstractImagine
{
    /**
     * @var ImagineInterface
     */
    private $wrapped;

    public function __construct()
    {
        $this->wrapped = new Imagine();
        $this->wrapped->setMetadataReader(new ExifMetadataReader());
        $this->autoRotateFilter = new AutoRotateFilterLoader();
    }

    public function create(BoxInterface $size, ColorInterface $color = null)
    {
        return $this->wrapped->create($size, $color);
    }

    public function open($path)
    {
        $image = $this->wrapped->open($path);

        return $this->autoRotateFilter->load($image);
    }

    public function load($string)
    {
        $image = $this->wrapped->load($string);

        return $this->autoRotateFilter->load($image);
    }

    public function read($resource)
    {
        return $this->wrapped->read($resource);
    }

    public function font($file, $size, ColorInterface $color)
    {
        return $this->wrapped->font($file, $size, $color);
    }
}
