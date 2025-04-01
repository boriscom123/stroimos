<?php
namespace AppBundle\Model\Doctrine;

use Doctrine\ORM\Mapping\Annotation;

/**
 * @Annotation
 */
class AutoBidirectionalManyToMany implements Annotation
{
    /**
     * @var string
     */
    public $targetEntity;
}