<?php

namespace AppBundle\Constraints;

use Symfony\Component\Validator\Constraint;

/**
 * @Annotation
 */
class ConstructionConstraint extends Constraint
{
    public $message = 'Необходимо заполнить поле "Статус объекта" во вкладке Характеристики';

    public function getTargets()
    {
        return self::CLASS_CONSTRAINT;
    }
} 