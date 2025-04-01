<?php
namespace AppBundle\Entity\Repository;

use AppBundle\Model\Specification\EntitySpecificationRepositoryTrait;
use Doctrine\ORM\EntityRepository;

class VideoRepository extends EntityRepository
{
    use EntitySpecificationRepositoryTrait;
}
