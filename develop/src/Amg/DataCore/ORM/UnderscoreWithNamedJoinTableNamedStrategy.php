<?php
namespace Amg\DataCore\ORM;

use Doctrine\ORM\Mapping\UnderscoreNamingStrategy;

class UnderscoreWithNamedJoinTableNamedStrategy extends UnderscoreNamingStrategy
{
    public function joinTableName($sourceEntity, $targetEntity, $propertyName = null)
    {
        return $this->classToTableName($sourceEntity) . '_' .
            ($propertyName ? $this->propertyToColumnName($propertyName) . '_' : '') .
            $this->classToTableName($targetEntity);
    }

}