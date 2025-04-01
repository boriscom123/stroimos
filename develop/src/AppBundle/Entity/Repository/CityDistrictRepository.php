<?php
namespace AppBundle\Entity\Repository;

use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\NonUniqueResultException;
use Doctrine\ORM\NoResultException;

class CityDistrictRepository extends EntityRepository
{
    public function findDistrictByTitleAndAreaAbbreviation($districtTitle, $areaAbbreviation)
    {
        $qb = $this->createQueryBuilder('d');
        $qb
            ->where($qb->expr()->eq('d.title', ':district_title'))
            ->setParameter('district_title', trim($districtTitle));
        $qb->join('d.parent', 'a')
            ->andWhere('a.abbreviation = :area_abbreviation')
            ->setParameter('area_abbreviation', $areaAbbreviation);

        try {
            $unit = $qb->getQuery()->getSingleResult();

            return $unit;
        } catch (NonUniqueResultException $e) {
            return null;
        } catch (NoResultException $e) {
            return null;
        }
    }
}
