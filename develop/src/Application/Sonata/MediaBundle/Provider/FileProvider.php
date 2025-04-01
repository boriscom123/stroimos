<?php
namespace Application\Sonata\MediaBundle\Provider;

use Sonata\MediaBundle\Model\MediaInterface;
use Symfony\Component\HttpFoundation\File\MimeType\MimeTypeExtensionGuesser;

class FileProvider extends \Sonata\MediaBundle\Provider\FileProvider
{
    protected static $iconMap = [
        'file' => 'file',
        /*'pdf'  => '',
        'txt'  => '',
        'rtf'  => '',
        'doc'  => '',
        'docx' => '',
        'xls'  => '',
        'xlsx' => '',
        'ppt'  => '',
        'pttx' => '',
        'odt'  => '',
        'odg'  => '',
        'odp'  => '',
        'ods'  => '',
        'odc'  => '',
        'odf'  => '',
        'odb'  => '',
        'csv'  => '',
        'xml'  => '',*/
    ];

    public function generatePublicUrl(MediaInterface $media, $format)
    {
        if ('file_thumb' !== $format && 'admin' !== $format) {
            return parent::generatePublicUrl($media, $format);
        }

        $extension = (new MimeTypeExtensionGuesser())->guess($media->getContentType()) ?: 'file';
        $icon = isset(self::$iconMap[$extension])
            ? self::$iconMap[$extension]
            : self::$iconMap['file'];
        $path = sprintf('/images/file/%s.png', $icon);

        //todo: make with cdn?
        return $path;
    }
}