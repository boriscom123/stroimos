<?php
namespace AppBundle\DoctrineFilter;

use AppBundle\Entity\Post;
use Doctrine\ORM\Mapping\ClassMetadata;
use Doctrine\ORM\Query\Filter\SQLFilter;

class NotMovedToTrash extends SQLFilter
{
    public function addFilterConstraint(ClassMetadata $targetEntity, $targetTableAlias)
    {
        $targetEntityClassName = $targetEntity->reflClass->getName();
        if ($targetEntityClassName !== Post::class) {
            return '';
        }

        return $targetTableAlias.'.deleted_at IS NULL';
    }
}
