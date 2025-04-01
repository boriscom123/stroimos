<?php
namespace Import;

use AppBundle\Entity\Embeddable\Address;
use AppBundle\Entity\Embeddable\ConstructionStatus;
use AppBundle\Entity\MetroLine;
use AppBundle\Entity\MetroStation;
use AppBundle\Model\ValueObject\GeoPoint;
use Import;
use Import\Helper\YandexGeoCoder;

class ImportMetroStationsData extends BaseImport
{
    const METRO_LINE_REF_PATTERN = 'metro-station-%u';

    protected $canBeSkipped = true;

    protected $stationsData = [];

    public function doLoad()
    {
        $data = json_decode(file_get_contents(__DIR__ . '/../AppBundle/DataFixtures/data/const_metro.json'), true);

        foreach ($data as $datum) {
            if ($datum['sub_id'] === 0) {
                $line = new MetroLine();
                $line->setId($datum['id']);
                $line->setTitle($datum['name']);
                $line->setColor($datum['color']);
                $line->setPublishable(true);
                $this->manager->persist($line);

                $this->setReference(sprintf(self::METRO_LINE_REF_PATTERN, $line->getId()), $line);
            } else {
                $datum['published_at'] = true;
                //$this->stationsData[$datum['name']]['datum'] = $datum;
            }
        }
        $this->manager->flush();

        $this->loadFromStructureTable('metro_stations', 109, 112, 137);
        $this->loadFromStructureTable('metro_stations', 109, 6, 107);

        $this->processStationsData();

        $this->loadStationData();
    }

    protected function loadStationData()
    {
        $i = 0;
        foreach ($this->stationsData as $station) {
            $sourceRow = $station['row'];

            $item = new MetroStation();
            $this->getCommonFieldSetter()->importCommonFields($item, $sourceRow);

            $item->setLine($this->getReference(sprintf(self::METRO_LINE_REF_PATTERN, $sourceRow['sub_id'])));

            $item->setPublishable(true);

            $address = new Address();
            $address->setGeoPoint($sourceRow['point']
                ? GeoPoint::createFromLonLatString(implode(',', $sourceRow['point']))
                : GeoPoint::createFromLonLatString('37.620393,55.753960')
            );
            $item->setAddress($address);

            if (!empty($sourceRow['slug'])) {
                $this->addRedirect($sourceRow['slug'], $item);
            }

            $item->setConstructionEndYear($this->guessConstructionEndYear($item->getTitle()));

            if ($item->getConstructionEndYear() <= 2014) {
                $item->setConstructionStatus(ConstructionStatus::create(ConstructionStatus::OBJ_STATUS__OPERATION));
            } else {
                $item->setConstructionStatus(ConstructionStatus::create(isset($sourceRow['status']) ? $sourceRow['status'] : ConstructionStatus::OBJ_STATUS__OPERATION));
            }

            $this->setMetroReference($item, $i ++);
            $this->manager->persist($item);
        }

        $this->manager->flush();
    }

    protected function processStationsData()
    {
        ksort($this->stationsData);

        $geoCoder = YandexGeoCoder::getInstance();

        array_walk($this->stationsData, function (&$row, $key) use ($geoCoder) {
            if (
                isset($row['datum'], $row['row']) &&
                $row['datum']['sub_id'] != $row['row']['sub_id']
            ) {
                throw new \RuntimeException("Линии станций не совпадают для $key");
            }


            if (isset($row['datum']) && !isset($row['row'])) {
                $row['row'] = [
                    'name' => $row['datum']['name'],
                    'sub_id' => $row['datum']['sub_id'],
                    'is_published' => true,
                ];
            }

            $row['row']['point'] = $geoCoder->getMetroStationPos($row['row']['name'], false);
        });
    }

    protected function loadFromStructureTable($type, $root, $lft, $rgt)
    {
        $mainTable = 'structure_item';
        $tagTable = 'news_tag';

        $query = $this->getSourceDb()->createQueryBuilder()
            ->select('*')
            ->from("st_{$mainTable}", "main")
            ->where("main.root_id=$root and lft > $lft and rgt < $rgt")
            ->orderBy('main.id', 'ASC');

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
            $this->loadFromRow($sourceRow);

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

    private function loadFromRow($sourceRow)
    {
        $sourceRow['published_at'] = $sourceRow['created_at'];
        $data = $sourceRow;
        $data['name'] = $this->clearStationName($sourceRow['name']);
        $data['sub_id'] = $this->guessLine($sourceRow['page_text']);
        $data['status'] = ConstructionStatus::OBJ_STATUS__CONSTRUCTION;

        $this->stationsData[$data['name'] . '-' . $data['sub_id']]['row'] = $data;
    }

    protected function clearStationName($name)
    {
        $name = str_replace(['"', 'Станция', '«', '»'], '', $name);
        $name = trim($name);
        $name = preg_replace('/\s+/', ' ', $name);

        return $name;
    }

    protected function guessLine($text)
    {
        $searchMap = [
            'Logo_Sokolnicheskaya.jpg' => 1,
            'Logo_Lublinsko-Dmitrovskaya.jpg' => 10,
            'Logo_Zamoskvoretskaya.jpg' => 2,
            'Logo_Kalininsko-Solntsevskaya(1).jpg' => 8,
            'Logo_TPK.jpg' => 1000,
            'logo_kajuxovskaya.jpg' => 1001,
            'Logo_Tagansko-Krasnopresnenskaya.jpg' => 7,
            'Logo_Butovskaya.jpg' => 12,
            'Logo_arbatsko-pokrovskaya.jpg' => 3,
            '%D1%86%D0%B2%D0%B5%D1%82_%D1%82%D0%B7.jpg' => 2,
            'Logo_Kaluzhsko-Rizhskaya.jpg' => 6,
        ];

        foreach($searchMap as $search => $line) {
            if (strpos($text, $search) !== false) {
                return  $line;
            }
        }

        return null;
    }

    protected function guessConstructionEndYear($station)
    {
        $constructionEndYear = [
//'2020' => ,
            'Беломорская улица' => 2020,
            'Волхонка' => 2020,
            'Дорогомиловская' => 2020,
            'Плющиха' => 2020,
            'Челобитьево' => 2020,
//'2018' => ,
            'Улица Новаторов' => 2018,
            'Терехово' => 2018,
            'Севастопольский проспект (Зюзино)' => 2018,
            'Кунцевская (ТПК)' => 2018,
            'Мневники' => 2018,
            'Улица Народного ополчения' => 2018,
            'Воронцовская' => 2018,
//'2017' => ,
            'Нижняя Масловка' => 2017,
            'Лефортово' => 2017,
            'Рассказовка' => 2017,
            'Новопеределкино' => 2017,
            'Юго-Восточная' => 2017,
            'Улица Дмитриевского' => 2017,
            'Стахановская' => 2017,
            'Боровское шоссе' => 2017,
            'Окская улица' => 2017,
            'Нижегородская улица' => 2017,
            'Некрасовка' => 2017,
            'Лухмановская' => 2017,
            'Косино' => 2017,
            'Авиамоторная' => 2017,
//'2016' => ,
            'Шелепиха' => 2016,
            'Хорошёвская' => 2016,
            'Ходынское поле' => 2016,
            'Петровский парк' => 2016,
            'Ломоносовский проспект' => 2016,
            'Очаково' => 2016,
            'Раменки' => 2016,
            'Мичуринский проспект' => 2016,
            'Солнцево' => 2016,
            'Говорово (Терешково)' => 2016,
            'Деловой центр (ТПК)' => 2016,
            'Верхние Лихоборы' => 2016,
            'Окружная' => 2016,
            'Селигерская' => 2016,
//'2015' => ,
            'Котельники' => 2015,
            'Румянцево' => 2015,
            'Саларьево' => 2015,
            'Бутырская' => 2015,
            'Фонвизинская' => 2015,
            'Петровско-Разумовская' => 2015,
            'Технопарк' => 2015,
            'Ховрино' => 2015,
//'2014' => ,
            'Спартак' => 2014,
            'Тропарево' => 2014,
//'2013' => ,
            'Битцевский парк' => 2013,
            'Лесопарковая' => 2013,
            'Парк Победы' => 2013,
            'Деловой центр' => 2013,
            'Жулебино' => 2013,
            'Лермонтовский проспект' => 2013,
//'2012' => ,
            'Алма-Атинская' => 2012,
            'Пятницкое шоссе' => 2012,
            'Новокосино' => 2012,
//'2011' => ,
            'Зябликово' => 2011,
            'Шипиловская' => 2011,
            'Борисово' => 2011,
        ];

        return isset($constructionEndYear[$station])
            ? $constructionEndYear[$station]
            : null;
    }
}
