<?php
namespace AppBundle\DataFixtures\ORM;

trait MediaHelperTrait
{
    /**
     * @return \Sonata\MediaBundle\Model\MediaManagerInterface
     */
    abstract public function getMediaManager();

    protected function createImage($file, $context)
    {
        if ($file[0] !== '/') {
            $file = __DIR__ . '/../files/' . $file;
        }

        $media = $this->getMediaManager()->create();
        $media->setBinaryContent($file);
        $media->setEnabled(true);
        $media->setProviderName('sonata.media.provider.image');
        $media->setContext($context);

        $this->getMediaManager()->save($media);

        return $media;
    }
}