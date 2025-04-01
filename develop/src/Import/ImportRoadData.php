<?php
namespace Import;

use AppBundle\Entity\Embeddable\Address;
use AppBundle\Entity\Embeddable\ConstructionStatus;
use AppBundle\Entity\Embeddable\RoadType;
use AppBundle\Entity\Road;
use AppBundle\Model\ValueObject\GeoPoint;
use Import;
use Import\Helper\YandexGeoCoder;

class ImportRoadData extends BaseImport
{
    protected $canBeSkipped = true;

    protected $sourceRowOverrides = [
        'varshavskoe-shosse' => [
            'name' => 'Варшавское шоссе'
        ]
    ];

    public function doLoad()
    {
        $this->loadFromStructureTable('road', 109, 226, 257, 4, RoadType::TYPE_INTERCHANGE, ConstructionStatus::OBJ_STATUS__CONSTRUCTION);
        $this->loadFromStructureTable('road', 'estakada-na-volokolamskom-shosse', null, null, null, RoadType::TYPE_OVERPASS, ConstructionStatus::OBJ_STATUS__CONSTRUCTION);

        $this->loadFromStructureTable('road', 'severo-zapadnaya-horda', null, null, null, RoadType::TYPE_SPAN, ConstructionStatus::OBJ_STATUS__CONSTRUCTION);
        $this->loadFromStructureTable('road', 'severo-vostochnaya-horda', null, null, null, RoadType::TYPE_SPAN, ConstructionStatus::OBJ_STATUS__CONSTRUCTION);
        $this->loadFromStructureTable('road', 'uzhnaya-rokada', null, null, null, RoadType::TYPE_SPAN, ConstructionStatus::OBJ_STATUS__CONSTRUCTION);

        $position = 0;
        $this->loadFromStructureTable('road', 'volgogradskii-prospekt', null, null, null, RoadType::TYPE_TRUNK, ConstructionStatus::OBJ_STATUS__CONSTRUCTION, $position++);
        $this->loadFromStructureTable('road', 'mozhaiskoe-shosse', null, null, null, RoadType::TYPE_TRUNK, ConstructionStatus::OBJ_STATUS__CONSTRUCTION, $position++);
        $this->loadFromStructureTable('road', 'ryazanskii-prospekt', null, null, null, RoadType::TYPE_TRUNK, ConstructionStatus::OBJ_STATUS__CONSTRUCTION, $position++);
        $this->loadFromStructureTable('road', 'shosse-entuziastov', null, null, null, RoadType::TYPE_TRUNK, ConstructionStatus::OBJ_STATUS__CONSTRUCTION, $position++);
        $this->loadFromStructureTable('road', 'schelkovskoe-shosse', null, null, null, RoadType::TYPE_TRUNK, ConstructionStatus::OBJ_STATUS__CONSTRUCTION, $position++);
        $this->loadFromStructureTable('road', 'dmitrovskoe-shosse-1', null, null, null, RoadType::TYPE_TRUNK, ConstructionStatus::OBJ_STATUS__CONSTRUCTION, $position++);
        $this->loadFromStructureTable('road', 'volokolamskoe-shosse', null, null, null, RoadType::TYPE_TRUNK, ConstructionStatus::OBJ_STATUS__CONSTRUCTION);
        $this->loadFromStructureTable('road', 'kaluzhskoe-shosse', null, null, null, RoadType::TYPE_TRUNK, ConstructionStatus::OBJ_STATUS__CONSTRUCTION);
        $this->loadFromStructureTable('road', 'rublevskoe-shosse', null, null, null, RoadType::TYPE_TRUNK, ConstructionStatus::OBJ_STATUS__OPERATION);
        $this->loadFromStructureTable('road', 'leningradskoe-shosse', null, null, null, RoadType::TYPE_TRUNK, ConstructionStatus::OBJ_STATUS__OPERATION);
        $this->loadFromStructureTable('road', 'varshavskoe-shosse', null, null, null, RoadType::TYPE_TRUNK, ConstructionStatus::OBJ_STATUS__OPERATION);
        $this->loadFromStructureTable('road', 'kashirskoe-shosse', null, null, null, RoadType::TYPE_TRUNK, ConstructionStatus::OBJ_STATUS__OPERATION);
        $this->loadFromStructureTable('road', 'yaroslavskoe-shosse', null, null, null, RoadType::TYPE_TRUNK, ConstructionStatus::OBJ_STATUS__OPERATION);
    }

    protected function loadFromStructureTable($type, $root, $lft = null, $rgt = null, $level = null, $roadType, $constructionStatus, $priorityPosition = null)
    {
        $mainTable = 'structure_item';
        $tagTable = 'news_tag';

        $query = $this->getSourceDb()->createQueryBuilder()
            ->select('*')
            ->from("st_{$mainTable}", "main")
            ->orderBy('main.id', 'ASC');

        if (is_string($root)) {
            $query->where("main.slug = '$root'");
        } else {
            $query->where("main.root_id=$root and lft > $lft and rgt < $rgt");

            if ($level) {
                $query->andWhere("main.level = $level");
            }
        }


        if ($tagTable) {
            $query
                ->addSelect('(' . $this->getSource()->createTagsSubQuery(false, $mainTable, $tagTable) . ') as tags')
                ->addSelect('(' . $this->getSource()->createTagsSubQuery(true, $mainTable, $tagTable) . ') as rubrics');
        }


        $totalCount = $this->getSource()->getCountByQueryBuilder($query);

        $progressBar = $this->createProgressBar($totalCount);

        $i = 0;
        $flushStep = 20;
        $this->getConsoleOutput()->writeln($type);
        foreach ($query->execute() as $sourceRow) {
            $this->loadFromRow($sourceRow, $roadType, $constructionStatus, $priorityPosition);

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

    private function loadFromRow($sourceRow, $roadType, $constructionStatus, $priorityPosition = null)
    {
        $sourceRow['published_at'] = $sourceRow['created_at'];

        if (isset($this->sourceRowOverrides[$sourceRow['slug']])) {
            $sourceRow = array_merge($sourceRow, $this->sourceRowOverrides[$sourceRow['slug']]);
        }

        $item = new Road();

        $item->setRoadType(RoadType::create($roadType));
        $item->setConstructionStatus(ConstructionStatus::create($constructionStatus));

        $point = YandexGeoCoder::getInstance()->getMetroStationPos($sourceRow['name'], false);

        $address = new Address();
        $address->setGeoPoint($point
            ? GeoPoint::createFromLonLatString(implode(',', $point))
            : GeoPoint::createFromLonLatString('37.620393,55.753960')
        );
        $item->setAddress($address);

        if (isset($priorityPosition)) {
            $item->setPriorityPosition($priorityPosition);
        }

        if (RoadType::TYPE_INTERCHANGE === $roadType) {
            if (preg_match_all("~/uploads/user_files/.+?\\.(jpg|png)~", $sourceRow['page_text'], $matches)) {
                $skipImages = [
                    '/uploads/user_files/images/1/nadanni_moment_2.jpg' => true
                ];
                foreach ($matches[0] as $match) {
                    if (isset($skipImages[$match])) {
                        continue;
                    }

                    $this->loadMedia($match, function ($image) use ($item) {
                        $item->setImage($image);
                    });
                    break;
                }
            }
        }

        $this->getCommonFieldSetter()->importCommonFields($item, $sourceRow);

        $this->addRedirect($sourceRow['slug'], $item);

        $this->manager->persist($item);
    }
}
