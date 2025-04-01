<?php
namespace AppBundle\Model\Specification;

use Doctrine\ORM\EntityRepository;

class EntitySpecificationRepository extends EntityRepository
{
    use EntitySpecificationRepositoryTrait;
}
