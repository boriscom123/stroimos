<?php

namespace AppBundle\DataFixtures\ORM;

use AppBundle\Entity\Gallery;
use AppBundle\Entity\GalleryMedia;
use AppBundle\Entity\Video;
use Application\Sonata\MediaBundle\Entity\Media;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\DataFixtures\AbstractFixture;
use Faker\Factory;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\Finder\Finder;

class LoadMediaData extends AbstractFixture implements ContainerAwareInterface, OrderedFixtureInterface
{
    use EntityManagerTrait,
        TaggerTrait;

    private $container;

    protected $faker;

    public static $mediaFilesCount = 0;

    private static $youtubeIds = [
        '18d36MkVYnA',
        'ZmGbcGAn_58',
        'wHJcTJZ3UVw',
        'AEw1rkt0PmA',
        '2FAMtpYxCoA',
        'CmV-aD5PxwU',
        'NgeMXjRtVsI',
        'qbit2suoUqw',
        'umitJLqarvg',
        '_cufxW9RQf4',
        'FImG0TcXUqY',
        'yzXmo4geiVc',
        '40G-wpCF8Pc',
        'RSeN67vVCXQ',
        '8VJuqPLVaNU',
        '_qCHhi-2VTU',
        'YiDHXpOuTbY',
    ];

    public function __construct()
    {
        $this->faker = Factory::create('ru_RU');
    }

    public function getOrder()
    {
        return FixturesOrder::L2;
    }

    public function setContainer(ContainerInterface $container = null)
    {
        $this->container = $container;
    }

    public static function getRandomImageId()
    {
        return 'media-id-' . rand(1, self::$mediaFilesCount);
    }

    public function load(ObjectManager $manager)
    {
        $this->setManager($manager);

        $mediaManager = $this->getMediaManager();

        $files = Finder::create()->name('*.*')->in(__DIR__.'/../files/documents');

        $i = 1;
        foreach ($files as $file) {
            /** @var Media $media */
            $media = $mediaManager->create();
            $media->setBinaryContent($file);
            $media->setEnabled(true);
            $media->setProviderName('sonata.media.provider.file');
            $media->setContext('file');

            $mediaManager->save($media);

            $this->setReference('media-file-id-'.$i++, $media);
        }

        $files = Finder::create()->name('*.jpg')->in(__DIR__.'/../files/images');
        $mediaFilesCount = self::$mediaFilesCount = count($files);

        $i = 1;
        foreach ($files as $file) {
            /** @var Media $media */
            $media = $mediaManager->create();
            $media->setBinaryContent($file);
            $media->setEnabled(true);
            $media->setProviderName('sonata.media.provider.image');
            $media->setContext('main_image');

            $mediaManager->save($media);

            $this->setReference('media-id-'.$i++, $media);
        }

        $i = 1;
        $files = Finder::create()->name('*.*')->in(__DIR__.'/../files/infographics');
        foreach ($files as $file) {
            /** @var Media $media */
            $media = $mediaManager->create();
            $media->setBinaryContent($file);
            $media->setEnabled(true);
            $media->setProviderName('sonata.media.provider.image');
            $media->setContext('main_image');

            $mediaManager->save($media);

            $this->setReference('infographics-image-media-id-'.$i, $media);

            /** @var Media $media */
            $media = $mediaManager->create();
            $media->setBinaryContent($file);
            $media->setEnabled(true);
            $media->setProviderName('sonata.media.provider.image');
            $media->setContext('infographics');

            $mediaManager->save($media);

            $this->setReference('infographics-media-id-'.$i, $media);

            $i++;
        }

        $files = Finder::create()->name('*.jpg')->in(__DIR__.'/../files/images');
        $galleryMedias = [];
        $i = 1;
        foreach ($files as $file) {
            /** @var Media $media */
            $media = $mediaManager->create();
            $media->setBinaryContent($file);
            $media->setEnabled(true);
            $media->setProviderName('sonata.media.provider.image');
            $media->setContext('gallery_media');

            $mediaManager->save($media);

            $galleryMedias[] = $media;
        }

        for ($i = 1; $i <= 20; $i ++) {
            $gallery = new Gallery();

            $videoRow = TextSource::getVideoRow();

            $gallery->setTitle($videoRow['name']);
//            $gallery->setTeaser($this->faker->realText(200));
            $gallery->setFeedable(true);
            $gallery->setPublishStartDate($this->faker->dateTimeBetween('-1 month'));
            $gallery->setPublishable(true);
            $gallery->setImage($this->getReference('media-id-' . rand(1, $mediaFilesCount)));
            if ($i <= 3) {
                $gallery->setPriorityPosition($i);
            }

            $gallery->setTags($this->getTags($videoRow['tags']));

            foreach (range(1, LoadRubricData::NUM_OF_RUBRICS) as $refId) {
                if (2 == rand(0,2)) {
                    $gallery->addRubric($this->getReference('-rubric-' . $refId));
                }
            }

            $manager->persist($gallery);

            $this->setReference('gallery-id-' . $i, $gallery);

            foreach (array_rand($galleryMedias, rand(3, count($galleryMedias))) as $galleryMediasKey) {
                $galleryMedia = new GalleryMedia();
                /*$galleryMedia->setTitle($this->faker->realText(50));
                $galleryMedia->setTeaser($this->faker->realText(200));*/
                $galleryMedia->setImage($galleryMedias[$galleryMediasKey]);
                $galleryMedia->setPublishable(true);
                $galleryMedia->setGallery($gallery);
                $manager->persist($galleryMedia);
            }

            if (!$this->hasReference('gallery-pick')) {
                $this->setReference('gallery-pick', $gallery);
            }
        }

        $this->loadVideos($manager, $mediaFilesCount);

        $manager->flush();
    }

    /**
     * @return \Sonata\MediaBundle\Model\MediaManagerInterface
     */
    public function getMediaManager()
    {
        return $this->container->get('sonata.media.manager.media');
    }
    /**
     * @return \Sonata\MediaBundle\Model\MediaManagerInterface
     */
    public function getGalleryManager()
    {
        return $this->container->get('sonata.media.manager.gallery');
    }
    /**
     * @return \Faker\Generator
     */
    public function getFaker()
    {
        return $this->container->get('faker.generator');
    }

    private function loadVideos(ObjectManager $manager, $mediaFilesCount)
    {
        $mediaManager = $this->getMediaManager();

        foreach (self::$youtubeIds as $key => $youtubeId) {
            /** @var Media $media */
            $media = $mediaManager->create();

            $media->setEnabled(true);
            $media->setBinaryContent($youtubeId);
            $media->setProviderName('sonata.media.provider.youtube');
            $media->setContext('video');

            $mediaManager->save($media);

            $videoRow = TextSource::getVideoRow();

            $video = new Video();
            $video->setPublishable(true);
            $video->setFeedable(true);
            $video->setVideo($media);
            $video->setImage($this->getReference('media-id-' . rand(1, $mediaFilesCount)));
            $video->setTitle($videoRow['name']);

            $video->setTags($this->getTags($videoRow['tags']));

            foreach (range(1, LoadRubricData::NUM_OF_RUBRICS) as $refId) {
                if (2 == rand(0,2)) {
                    $video->addRubric($this->getReference('-rubric-' . $refId));
                }
            }

            $manager->persist($video);

            if ($key < 4) {
                $this->setReference('video-pick-' . ($key + 1), $video);
            }
        }
    }
}
