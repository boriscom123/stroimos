<?php
namespace Import;

use AppBundle\Entity\Infographics;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;

class ImportInfographicsData extends BaseImport implements DependentFixtureInterface
{
    protected $canBeSkipped = true;

    protected $postPicks = [];

    public function getDependencies()
    {
        return [
            ImportTagData::class,
            ImportRubricData::class
        ];
    }

    public function doLoad()
    {
        $types = [
            [
                'main_table' => 'infographics',
                'tag_table' => 'infographics_tag',
                'statistics' => false,
                'small_image' => 'small_image',
            ],
            [
                'main_table' => 'statistics',
                'tag_table' => 'statistics_tag',
                'statistics' => true,
                'small_image' => 'mini_image',
            ],
        ];

        foreach ($types as $type) {
            call_user_func_array([$this, 'loadInfographics'], $type);
        }
    }

    protected function loadInfographics($mainTable, $tagTable, $isStatistics, $smallImage)
    {
        $query = $this->getSourceDb()->createQueryBuilder()
            ->select('*')
            ->addSelect('(' . $this->getSource()->createTagsSubQuery(false, $mainTable, $tagTable) .') as tags')
            ->addSelect('(' . $this->getSource()->createTagsSubQuery(true, $mainTable, $tagTable) .') as rubrics')
            ->from("st_{$mainTable}", "main")
            ->orderBy('main.id', 'ASC');

        $this->applyQuerySkips($mainTable, $query);

        $totalCount = $this->getSource()->getCountByQueryBuilder($query);

        $i = 0;
        $flushStep = 20;
        $this->getConsoleOutput()->writeln($mainTable);
        $progressBar = $this->createProgressBar($totalCount);
        foreach ($query->execute() as $sourceRow) {
            $this->loadInfographicsFromRow(
                $sourceRow,
                $isStatistics,
                $smallImage
            );

            if (++$i % $flushStep == 0) {
                $this->manager->flush();
                $this->manager->clear();
            }

            $progressBar->advance();
        }
        $this->getConsoleOutput()->writeln('');
        $this->manager->flush();
        $this->manager->clear();
    }

    protected function loadInfographicsFromRow($sourceRow, $isStatistics, $smallImage)
    {
        $item = new Infographics();
        $this->manager->persist($item);

        $item->setTeaser(html_entity_decode(strip_tags($sourceRow['description']), null, 'UTF-8'));
        $item->setContent($sourceRow['description']);

        $item->setType($isStatistics ? Infographics::TYPE_STATISTICS : Infographics::TYPE_INFOGRAPHICS);

        $this->getCommonFieldSetter()->importCommonFields($item, $sourceRow, ['description']);

        $imagePath = $isStatistics ? 'statistics' : 'infographics';

        $this->loadMedia("/uploads/$imagePath/image/" . $sourceRow['image'], function ($image) use ($item) {
            $item->setImage($image);
        });

        $this->loadMedia("/uploads/$imagePath/image/" . $sourceRow['image'], function ($image) use ($item) {
            $item->setInfographics($image);
        }, 'infographics');

        if ($isStatistics) {
            $this->addRedirect("/statistics/{$sourceRow['slug']}", $item);
        }
    }
}