<?php

namespace AppBundle\Admin\MediaProvider;

use Buzz\Browser;
use Gaufrette\Filesystem;
use Imagine\Image\ImagineInterface;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\MediaBundle\CDN\CDNInterface;
use Sonata\MediaBundle\Generator\GeneratorInterface;
use Sonata\MediaBundle\Metadata\MetadataBuilderInterface;
use Sonata\MediaBundle\Model\MediaInterface;
use Sonata\MediaBundle\Provider\ImageProvider;
use Sonata\MediaBundle\Thumbnail\ThumbnailInterface;
use Symfony\Component\Form\FormBuilder;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\NotNull;
use Symfony\Component\HttpFoundation\File\File;

class ExternalImageProvider extends ImageProvider
{
    /**
     * @var Browser
     */
    private $browser;

    /**
     * @param string $name
     * @param \Gaufrette\Filesystem $filesystem
     * @param \Sonata\MediaBundle\CDN\CDNInterface $cdn
     * @param \Sonata\MediaBundle\Generator\GeneratorInterface $pathGenerator
     * @param \Sonata\MediaBundle\Thumbnail\ThumbnailInterface $thumbnail
     * @param array $allowedExtensions
     * @param array $allowedMimeTypes
     * @param \Imagine\Image\ImagineInterface $adapter
     * @param \Sonata\MediaBundle\Metadata\MetadataBuilderInterface $metadata
     * @param Browser $browser
     */
    public function __construct(
        $name,
        Filesystem $filesystem,
        CDNInterface $cdn,
        GeneratorInterface $pathGenerator,
        ThumbnailInterface $thumbnail,
        array $allowedExtensions = array(),
        array $allowedMimeTypes = array(),
        ImagineInterface $adapter,
        MetadataBuilderInterface $metadata = null,
        Browser $browser
    )
    {
        parent::__construct(
            $name,
            $filesystem,
            $cdn,
            $pathGenerator,
            $thumbnail,
            $allowedExtensions,
            $allowedMimeTypes,
            $adapter,
            $metadata = null
        );

        $this->browser = $browser;
    }

    public function buildCreateForm(FormMapper $formMapper)
    {
        $formMapper->add('binaryContent', 'text');
    }

    public function buildEditForm(FormMapper $formMapper)
    {
        parent::buildEditForm($formMapper);
        $formMapper->add('binaryContent', 'text', array('required' => false));
    }

    /**
     * {@inheritdoc}
     */
    public function     buildMediaType(FormBuilder $formBuilder)
    {
        $formBuilder->add('binaryContent', 'text');
    }

    protected function fixBinaryContent(MediaInterface $media)
    {
        if ($media->getBinaryContent() === null) {
            return;
        }

        if (!$media->getBinaryContent() instanceof File) {
            if (!is_file($media->getBinaryContent())) {
                $url = $media->getBinaryContent();

                $response = $this->browser->get($url);

                $filename = explode('/', $url);
                $filename = $filename[count($filename) - 1];

                $image = $response->getContent();

                $fullFilename = $this->pathGenerator->generatePath($media) . '/' . $filename;

                $this->getFilesystem()->getAdapter()->write($fullFilename, $image);

                $media->setBinaryContent(__DIR__ . '/../../../../web/uploads/media/' . $fullFilename);
            }
        }

        parent::fixBinaryContent($media);
    }

    /**
     * {@inheritdoc}
     */
    protected function doTransform(MediaInterface $media)
    {
        $this->fixBinaryContent($media);

        parent::doTransform($media);
    }
}