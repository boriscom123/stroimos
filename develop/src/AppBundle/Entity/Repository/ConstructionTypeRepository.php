<?php
namespace AppBundle\Entity\Repository;

use AppBundle\Entity\ConstructionType;
use Doctrine\ORM\EntityRepository;

class ConstructionTypeRepository extends EntityRepository
{
    public function getSelectOptions()
    {
        $options = [];

        foreach ($this->findBy([], ['title' => 'ASC']) as $type) {
            /** @var ConstructionType $type */
            $options[$type->getAlias()] = $type->getTitle();
        }

        return $options;
    }
}
