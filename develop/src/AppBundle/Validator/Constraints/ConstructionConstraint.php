<?php

namespace AppBundle\Validator\Constraints;

use Symfony\Component\Validator\Constraint;

/**
* @Annotation
*/
class ConstructionConstraint extends Constraint
{
    public $message = 'Не заполнено поле "Координаты точки Х, У для пиктограммы" в характеристиках объекта';

    public function getTargets()
    {
        return self::CLASS_CONSTRAINT;
    }
}