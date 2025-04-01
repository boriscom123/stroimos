<?php
namespace AppBundle\DoctrineFilter;

use Doctrine\ORM\Mapping\ClassMetadata;
use Doctrine\ORM\Query\Filter\SQLFilter;

class PublishingPeriod extends SQLFilter
{
    public function addFilterConstraint(ClassMetadata $targetEntity, $targetTableAlias)
    {
        if (!$targetEntity->reflClass->implementsInterface('Amg\DataCore\Model\PublishingPeriod\PublishingPeriodInterface')) {
            return '';
        }

        return sprintf('(%1$s.publish_start_date IS NULL OR %1$s.publish_start_date <= NOW()) AND (%1$s.publish_end_date IS NULL OR NOW() < %1$s.publish_end_date )', $targetTableAlias);
    }
}
