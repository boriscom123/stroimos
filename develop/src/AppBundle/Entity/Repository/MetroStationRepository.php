<?php
namespace AppBundle\Entity\Repository;

use AppBundle\Entity\MetroStation;
use Doctrine\ORM\EntityRepository;

class MetroStationRepository extends EntityRepository
{
    public function getStationsUnderConstructionByLine()
    {
        $query = $this->getEntityManager()->createQuery(sprintf(
            'SELECT s, l FROM %s s JOIN s.line l WHERE s.constructionEndYear >= :periodFrom AND s.constructionEndYear <= :periodTo ORDER BY l.number ASC, s.constructionEndYear, s.title',
            $this->getClassName()
        ));

        $stations = $query->execute([
            'periodFrom' => 2024,
            'periodTo' => 2200,
        ]);

        $stationsByLine = [];
        $stationsByLineNumber = [];
        foreach ($stations as $station) {
            /** @var MetroStation $station */
            //$stationsByLine[$station->getLine()->getTitle()][] = $station;
            $stationsByLineNumber[$station->getLine()->getNumber()][] = $station;
        }

        ksort($stationsByLineNumber);

        foreach ($stationsByLineNumber as $stations) {
            /** @var MetroStation $station */
            foreach ($stations as $station) {
                $stationsByLine[$station->getLine()->getTitle()][] = $station;
            }
        }

//        $lineOrder = array('Троицкая линия', 'Бирюлёвская линия', 'Рублёво-Архангельская линия', 'Сокольническая линия', 'Люблинско-Дмитровская линия', 'Арбатско-Покровская линия',   'Большая кольцевая линия');
//        $lineOrder = array_reverse($lineOrder);
//        foreach ($lineOrder as $line_name) {
//            if(!isset($stationsByLine[$line_name])) continue;
//            $line = $stationsByLine[$line_name];
//            if ($line) {
//                unset($stationsByLine[$line_name]);
//                $stationsByLine = array($line_name => $line) + $stationsByLine;
//            }
//        }

        return $stationsByLine;
    }

    public function getStationsUnderConstruction()
    {
        $query = $this->getEntityManager()->createQuery(sprintf(
            'SELECT s, l FROM %s s JOIN s.line l WHERE s.constructionEndYear > :constructionEndYear ORDER BY s.constructionEndYear, l.title, s.title',
            $this->getClassName()
        ));

        $stations = $query->execute([
            'constructionEndYear' => date('Y') - 1,
        ]);

        $stationsByConstructionEndYear = [];
        foreach ($stations as $station) {
            /** @var MetroStation $station */
            $stationsByConstructionEndYear[$station->getConstructionEndYear()][] = $station;
        }

        return $stationsByConstructionEndYear;
    }

    public function getStationsWithVideo()
    {
        $query = $this->getEntityManager()->createQuery(sprintf(
            'SELECT s, l, v FROM %s s JOIN s.line l JOIN s.video v ORDER BY s.title',
            $this->getClassName()
        ));

        return $query->execute();
    }
}
