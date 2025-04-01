<?php
namespace AppBundle\DataFixtures\ORM;

use AppBundle\Entity\Embeddable\Address;
use AppBundle\Entity\Embeddable\ConstructionStatus;
use AppBundle\Entity\MetroLine;
use AppBundle\Entity\MetroStation;
use AppBundle\Model\ValueObject\GeoPoint;
use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\Persistence\ObjectManager;

class LoadMetroStationsData extends AbstractFixture
{
    const METRO_LINE_REF_PATTERN = 'metro-station-%u';

    public function load(ObjectManager $manager)
    {
        $data = json_decode(file_get_contents(__DIR__ . '/../data/const_metro.json'), true);

        foreach ($data as $datum) {
            if ($datum['sub_id'] === 0) {
                // metro line
                $line = new MetroLine();
                $line->setId($datum['id']);
                $line->setTitle($datum['name']);
                $line->setColor($datum['color']);
                $line->setPublishable(true);
                $manager->persist($line);

                $this->setReference(sprintf(self::METRO_LINE_REF_PATTERN, $line->getId()), $line);
            } else {
                // metro station
                $station = new MetroStation();
                $station->setId($datum['id']);
                $station->setTitle($datum['name']);
                /** @var MetroLine $line */
                $line = $this->getReference(sprintf(self::METRO_LINE_REF_PATTERN, $datum['sub_id']));
                $station->setLine($line);
                $station->setPublishable(true);
                $station->setConstructionStatus(ConstructionStatus::create(ConstructionStatus::OBJ_STATUS__OPERATION));
                $constructionEndYear = rand(date('Y') - 2, date('Y') + 5);
                $station->setConstructionEndYear($constructionEndYear);
                $station->setConstructionStartYear($constructionEndYear - rand(2, 6));
                $address = new Address();
                $address->setGeoPoint(GeoPoint::createFromLonLatString('37.620393,55.75396'));
                $station->setAddress($address);

                $manager->persist($station);
            }
        }

        $manager->flush();
    }
}
