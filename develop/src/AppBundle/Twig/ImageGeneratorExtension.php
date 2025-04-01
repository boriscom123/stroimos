<?php
namespace AppBundle\Twig;

use Imagick;
use ImagickDraw;
use ImagickPixel;

class ImageGeneratorExtension extends \Twig_Extension
{
    /**
     * @var string
     */
    protected $webDir;

    /**
     * @var string
     */
    protected $uploadDir;

    /**
     * ImageGeneratorExtension constructor.
     * @param $webDir string
     * @param $uploadDir string
     */
    public function __construct($webDir, $uploadDir)
    {
        $this->webDir = $webDir;
        $this->uploadDir = $uploadDir;
    }

    public function getName()
    {
        return 'image_generator';
    }

    public function getFunctions()
    {
        return [
            new \Twig_SimpleFunction('generateImage', [$this,'generateImage'])
        ];
    }

    /**
     * @param $label string
     * @param $fontSize int
     * @param $width int
     * @param $height int
     * @return string
     * @throws \ErrorException
     */
    public function generateImage($label, $fontSize, $width, $height)
    {
        $hash = md5(sprintf('%s_%s_%s_%s', $label, $fontSize, $width, $height));
        $dir = trim($this->uploadDir, '/') . '/newsletter/';
        $absDir = $this->webDir . '/' . $dir;
        if(!is_dir($absDir)) {
            mkdir($absDir);
        }
        $file = $hash . '.png';

        if(file_exists($absDir . $file)) {
            return $dir . $file;
        }
        if(empty($label)) {
            throw new \ErrorException('label is required');
        }

        $image = new Imagick();
        $image->newImage($width, $height, new ImagickPixel('transparent'));

        $draw = new ImagickDraw();
        $draw->setFontSize($fontSize);
        $color = new ImagickPixel('#888888');
        $draw->setFillColor($color);
        $draw->setGravity(Imagick::GRAVITY_CENTER);
        $draw->setTextAntialias(true);
        $draw->setTextKerning(5);
        $draw->setFont('fonts/AvenirNext/AvenirNextCyr-Light.ttf');
        $image->annotateimage($draw, 0, 0, -90, $label);

        $image->writeImage($absDir . $file);

        return $dir . $file;
    }
}
