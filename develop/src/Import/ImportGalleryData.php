<?php
namespace Import;

use AppBundle\Entity\Gallery;
use AppBundle\Entity\GalleryMedia;
use AppBundle\Entity\GalleryPicks;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;

class ImportGalleryData extends BaseImport implements DependentFixtureInterface
{
    protected $picks = [];

    protected $status;

    protected $skipAlbumLimits = false;

    protected $canBeSkipped = true;

    public function getDependencies()
    {
        return [
            ImportTagData::class,
            ImportRubricData::class,
        ];
    }

    public function doLoad()
    {
        $mainTable = 'album';
        $tagTable = 'photo_tag';

        $query = $this->getSourceDb()->createQueryBuilder()
            ->select('main.*')
            ->addSelect('category.name as rubrics')
            ->addSelect('(SELECT cover.pathname FROM st_photo cover WHERE cover.album_id = main.id ORDER BY cover.is_cover DESC, cover.created_at ASC LIMIT 1) as pathname')
            ->addSelect('(' . $this->getSource()->createTagsSubQuery(false, $mainTable, $tagTable) . ') as tags')
            ->from("st_{$mainTable}", "main")
            ->leftJoin("main", "st_album_category", "category", "category.id = main.album_category_id")
            ->where('main.is_excluded = 0')
            ->orderBy('main.id', 'ASC');

        $this->applyQuerySkips('album', $query);

        $totalCount = $this->getSource()->getCountByQueryBuilder($query);

        $i = 0;
        $flushStep = 20;
        echo "\n";
        foreach ($query->execute() as $sourceRow) {
            ++$i;
            echo $this->status = "\r$mainTable: $totalCount / $i";
            echo '                                               ';

            $this->skipAlbumLimits = $totalCount != $i;

            $this->loadFromRow($mainTable, $sourceRow);

            if ($i % $flushStep == 0) {
                $this->manager->flush();
                $this->manager->clear();
            }
        }
        echo "\n";
        $this->manager->flush();
        $this->manager->clear();

        $this->createPicks();
    }

    private function loadFromRow($mainTable, $sourceRow)
    {
        $item = new Gallery();
        $this->manager->persist($item);

        $item->setPublishable(true);

        $this->getCommonFieldSetter()->importCommonFields($item, $sourceRow, ['description']);

        $this->loadMedia("/uploads/photo/{$sourceRow['pathname']}", function ($image) use ($item) {
            $item->setImage($image);
        });

        if ($sourceRow['is_on_main']) {
            $this->picks[$item->getPublishStartDate()->format('Y-m-d-H-i-s')] = $item;
        }

        $this->addRedirect("/photogallery/album/" . $sourceRow['slug'], $item);

        $this->loadGalleryMedias($sourceRow, $item);
    }

    protected function loadGalleryMedias($galleryRow, Gallery $gallery)
    {
        $mainTable = 'photo';
        $tagTable = 'photo_tag';

        $query = $this->getSourceDb()->createQueryBuilder()
            ->select('main.*')
            ->addSelect('(' . $this->getSource()->createTagsSubQuery(false, $mainTable, $tagTable) . ') as tags')
            ->from("st_{$mainTable}", "main")
            ->where("main.album_id = {$galleryRow['id']}")
            ->orderBy('main.is_cover', 'DESC')
            ->orderBy('main.created_at', 'ASC');

        if ($this->skipAlbumLimits) {
            $this->applyQuerySkips('album_photo', $query);
        }

        $totalCount = $this->getSource()->getCountByQueryBuilder($query);

        $i = 0;
        foreach ($query->execute() as $sourceRow) {
            echo $this->status ."; $mainTable: $totalCount / $i";

            $this->loadGalleryMediaFromRow($mainTable, $sourceRow, $gallery);

            ++$i;
        }
    }

    protected function loadGalleryMediaFromRow($mainTable, $sourceRow, Gallery $gallery)
    {
        $item = new GalleryMedia();
        $this->manager->persist($item);
        $item->setGallery($gallery);

        $item->setPublishable(empty($sourceRow['is_excluded']));

        $this->getCommonFieldSetter()->importCommonFields($item, $sourceRow);

        $this->loadMedia("/uploads/photo/{$sourceRow['pathname']}", function ($image) use ($item) {
            $item->setImage($image);
        }, 'gallery_media');
    }

    protected function createPicks()
    {
        ksort($this->picks);

        $picks = array_slice($this->picks, 0, 5);
        foreach($picks as $gallery) {
            $gallery = $this->manager->getReference(Gallery::class, $gallery->getId());

            $galleryPicks = new GalleryPicks();
            $galleryPicks->setGallery($gallery);
            $this->manager->persist($galleryPicks);
        }
        $this->manager->flush();
    }
}
