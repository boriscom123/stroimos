<?php
namespace AppBundle\Entity\Repository;

use Doctrine\ORM\Query;
use Happyr\DoctrineSpecification\EntitySpecificationRepository;

class ContactPersonRepository extends EntitySpecificationRepository
{
    public function getFirstLettersAvailable()
    {
        $query = $this->_em->createQuery(sprintf(
            'SELECT DISTINCT %1$s FROM AppBundle\Entity\ContactPerson cp LEFT JOIN cp.organization AS o WHERE cp.organization IS NULL OR o.publishable = true ORDER BY %1$s',
            'UPPER(SUBSTRING(cp.lastName, 1, 1))'
        ));

        return array_map('current', $query->getResult(Query::HYDRATE_SCALAR));
    }
}
