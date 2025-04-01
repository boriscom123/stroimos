<?php
namespace AppBundle\Model;

use Amg\DataCore\ValueObject\EntityReference;

trait EntityReferenceTrait
{
    /**
     * @Serializer\VirtualProperty
     * @Serializer\SerializedName("id")
     * @Serializer\Groups({"api"})
     *
     * @return string
     */
    public function getEntityReference()
    {
        return (string)EntityReference::createFromEntity($this);
    }
}
