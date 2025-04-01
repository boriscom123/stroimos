<?php
namespace Import;

use AppBundle\Entity\Video;
use AppBundle\Entity\VideoPicks;
use Application\Sonata\MediaBundle\Entity\Media;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;

class ImportVideoData extends BaseImport implements DependentFixtureInterface
{
    protected $picks = [];

    protected $canBeSkipped = true;

    public function getDependencies()
    {
        return [
            ImportTagData::class,
            ImportRubricData::class
        ];
    }

    public function doLoad()
    {
        $mainTable = 'video';
        $tagTable = 'video_tag';

        $query = $this->getSourceDb()->createQueryBuilder()
            ->select('main.*')
            ->addSelect('(' . $this->getSource()->createTagsSubQuery(false, $mainTable, $tagTable) . ') as tags')
            ->from("st_{$mainTable}", "main")
            ->where('main.is_excluded = 0')
            ->orderBy('main.id', 'ASC');

        $this->applyQuerySkips('video', $query);

        $totalCount = $this->getSource()->getCountByQueryBuilder($query);
        $progressBar = $this->createProgressBar($totalCount);

        $i = 0;
        $flushStep = 1;
        $this->getConsoleOutput()->writeln($mainTable);
        foreach ($query->execute() as $sourceRow) {
            $progressBar->advance();

            if ($this->applyQuerySkips) {
                $videoUrl = "http://stroi.mos.ru/uploads/video/video/{$sourceRow['file']}";
                $videoSize = $this->remoteFilesize($videoUrl);
                $this->getConsoleOutput()->writeln("$videoUrl: " . ceil($videoSize / 1024 / 1024) . " MB ($videoSize)");
                if ($videoSize > 1024 * 1024 * 100) {
                    continue;
                }
            }

            $this->loadFromRow($mainTable, $sourceRow, $i);

            if (++$i % $flushStep == 0) {
                $this->manager->flush();
                $this->manager->clear();
            }

            //gc_collect_cycles();
            $this->displayMemoryUsage();
        }
        echo "\n";
        $this->manager->flush();
        $this->manager->clear();

        $this->createPicks();
    }

    private function loadFromRow($mainTable, $sourceRow, $i)
    {
        $item = new Video();
        $this->manager->persist($item);

        $item->setPublishable(true);

        $this->getCommonFieldSetter()->importCommonFields($item, $sourceRow);

        $this->loadMedia("/uploads/video/{$sourceRow['image']}", function ($image) use ($item) {
            $item->setImage($image);
        });

        $this->loadMedia("/uploads/video/video/{$sourceRow['file']}", function (Media $video) use ($item) {
            $item->setVideo($video);
        }, 'video', 'sonata.media.provider.video');

        if ($sourceRow['is_on_main']) {
            $this->picks[$item->getPublishStartDate()->format('Y-m-d-H-i-s')] = $item;
        }

        $this->addRedirect("/videogallery/video/" . $sourceRow['slug'], $item);

        if ($i < 5) {
            $this->setVideoReference($item, $i);
        }
    }

    protected function createPicks()
    {
        ksort($this->picks);

        $picks = array_slice($this->picks, 0, 4);
        foreach($picks as $video) {
            $video = $this->manager->getReference(Video::class, $video->getId());

            $pick = new VideoPicks();
            $pick->setVideo($video);
            $this->manager->persist($pick);
        }
        $this->manager->flush();
    }

    protected function remoteFilesize($url) {
        static $regex = '/^Content-Length: *+\K\d++$/im';

        if (!$fp = @fopen($url, 'rb')) {
            throw new \RuntimeException("Unable to get '$url' file size");
        }

        if (
            isset($http_response_header) &&
            preg_match($regex, implode("\n", $http_response_header), $matches)
        ) {
            return (int)$matches[0];
        }
        throw new \RuntimeException("Unable to get '$url' file size");
    }
}
