<?php

namespace Application\Sonata\MediaBundle\Imagine;

use Imagine\Image\ImageInterface;
use Liip\ImagineBundle\Imagine\Filter\Loader\LoaderInterface;

/**
 * AutoRotateFilterLoader - rotates an Image based on its EXIF Data.
 *
 * @author Robert Schönthal <robert.schoenthal@gmail.com>
 */
class AutoRotateFilterLoader implements LoaderInterface
{
    const ORIENTATION_HORIZONTAL                          = 1;
    const ORIENTATION_MIRROR_HORIZONTAL                   = 2;
    const ORIENTATION_ROTATE_180                          = 3;
    const ORIENTATION_MIRROR_VERTICAL                     = 4;
    const ORIENTATION_MIRROR_HORIZONTAL_AND_ROTATE_270_CW = 5;
    const ORIENTATION_ROTATE_90_CW                        = 6;
    const ORIENTATION_MIRROR_HORIZONTAL_AND_ROTATE_90_CW  = 7;
    const ORIENTATION_ROTATE_270_CW                       = 8;

    protected $orientationKeys = array(
        'exif.Orientation',
        'ifd0.Orientation',
    );

    /**
     * {@inheritDoc}
     */
    public function load(ImageInterface $image, array $options = array())
    {
        if ($orientation = $this->getOrientation($image)) {
            $degree = $this->calculateRotation((int) $orientation);

            if ($degree !== 0) {
                $image->rotate($degree);
                $image->metadata()->offsetSet('ifd0.Orientation', 1);
                $image->metadata()->offsetSet('exif.Orientation', 1);
            }
        }

        return $image;
    }

    /**
     * calculates to rotation degree from the EXIF Orientation.
     *
     * @param int $orientation
     *
     * @return int
     */
    private function calculateRotation($orientation)
    {
        switch ($orientation) {
            case self::ORIENTATION_ROTATE_270_CW:
                $degree = -90;
                break;
            case self::ORIENTATION_ROTATE_180:
                $degree = 180;
                break;
            case self::ORIENTATION_ROTATE_90_CW:
                $degree = 90;
                break;
            default:
                $degree = 0;
                break;
        }

        return $degree;
    }

    /**
     * @param ImageInterface $image
     *
     * @return int
     */
    private function getOrientation(ImageInterface $image)
    {
        //>0.6 imagine meta data interface
        if (method_exists($image, 'metadata')) {
            foreach ($this->orientationKeys as $orientationKey) {
                $orientation = $image->metadata()->offsetGet($orientationKey);

                if ($orientation) {
                    return $orientation;
                }
            }

            return;
        } else {
            $data = exif_read_data('data://image/jpeg;base64,'.base64_encode($image->get('jpg')));

            return isset($data['Orientation']) ? $data['Orientation'] : null;
        }
    }
}
