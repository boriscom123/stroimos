<?php
namespace Import;

use AppBundle\Entity\Destruction;
use AppBundle\Entity\Embeddable\Address;
use AppBundle\Model\ValueObject\GeoPoint;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;

class ImportDestructionData extends BaseImport implements DependentFixtureInterface
{
    public function getDependencies()
    {
        return [
            LoadAdministrativeUnitData::class
        ];
    }

    public function doLoad()
    {
        $query = $this->getSourceDb()->createQueryBuilder()
            ->select('*')
            ->from('st_destruction_address');

        foreach ($query->execute() as $sourceRow) {
            $destruction = new Destruction();
            $destruction->setDestructionYear($sourceRow['destuction_year']);
            $destruction->setDestructionQuarter($sourceRow['destuction_quarter']);
            $destruction->setSeries($sourceRow['seria']);
            $destruction->setDestructed('DESTRUCTED' === $sourceRow['status']);

            $administrativeUnitI = $sourceRow['district_id'];
            if (10 == $administrativeUnitI) {
                $administrativeUnitI = 11;
            } elseif ($administrativeUnitI > 10) {
                $administrativeUnitI --;
            }
            $destruction->setAdministrativeUnit($this->getReference(sprintf('administrative-unit-%u', $administrativeUnitI)));

            $address = new Address();
            $address->setText($sourceRow['address']);
            $address->setGeoPoint(GeoPoint::createFromLonLat($sourceRow['lng'], $sourceRow['lat']));
            $destruction->setAddress($address);

            $this->manager->persist($destruction);
        }

        $this->manager->flush();
    }
}