<?php
namespace AppBundle\Entity\Repository;

use Doctrine\ORM\Query;
use Happyr\DoctrineSpecification\EntitySpecificationRepository;

class OrganizationRepository extends EntitySpecificationRepository
{
    public function getFirstLettersAvailable()
    {
        $query = $this->_em->createQuery(sprintf(
            'SELECT DISTINCT %1$s FROM AppBundle\\Entity\\Organization o ORDER BY %1$s',
            'UPPER(SUBSTRING(o.title, 1, 1))'
        ));

        $result = $query->getResult(Query::HYDRATE_SCALAR);

        $notIsNumeric = function ($v) {
            return !is_numeric($v);
        };

        return array_filter(array_map('current', $result), $notIsNumeric);
    }
}
