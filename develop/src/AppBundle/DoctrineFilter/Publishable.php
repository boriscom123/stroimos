<?php
namespace AppBundle\DoctrineFilter;

use Doctrine\ORM\Mapping\ClassMetadata;
use Doctrine\ORM\Query\Filter\SQLFilter;

class Publishable extends SQLFilter
{
    public function addFilterConstraint(ClassMetadata $targetEntity, $targetTableAlias)
    {
        if (!$targetEntity->reflClass->implementsInterface('Amg\DataCore\Model\Publishable\PublishableInterface')) {
            return '';
        }

        return $targetTableAlias.'.publishable = 1';
    }
}
