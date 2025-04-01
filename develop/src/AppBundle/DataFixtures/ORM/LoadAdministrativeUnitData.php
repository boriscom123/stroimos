<?php
namespace AppBundle\DataFixtures\ORM;

use AppBundle\Entity\AdministrativeArea;
use AppBundle\Entity\CityDistrict;
use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\Persistence\ObjectManager;

class LoadAdministrativeUnitData extends AbstractFixture
{
    public function load(ObjectManager $manager)
    {
        $i = 0;
        foreach (CityDistrict::$availableDistricts as $okrugTitle => $okrugDistricts) {
            $okrug = new AdministrativeArea();
            $okrug->setTitle($okrugTitle);
            $okrug->setAbbreviation($this->abbreviate($okrugTitle));
            $manager->persist($okrug);

            $this->setReference(sprintf('administrative-unit-%u', ++$i), $okrug);

            foreach ($okrugDistricts as $districtTitle) {
                $district = new CityDistrict();
                $district->setTitle($districtTitle);
                $district->setParent($okrug);

                $manager->persist($district);

                $this->setReference(sprintf('administrative-unit-%u', ++$i), $district);
            }
        }

        $manager->flush();
    }

    private function abbreviate($title)
    {
        if ($title === 'Зеленоградский') {
            return 'ЗелАО';
        }

        return implode('', array_map(function ($word) {
            return mb_convert_case(mb_substr($word, 0, 1, 'UTF-8'), MB_CASE_UPPER, 'UTF-8');
        }, preg_split('/[- ]/', $title))) . 'АО';
    }
}
