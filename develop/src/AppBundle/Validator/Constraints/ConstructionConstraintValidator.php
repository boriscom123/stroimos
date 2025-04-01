<?php

namespace AppBundle\Validator\Constraints;

use AppBundle\Entity\Construction;
use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;

class ConstructionConstraintValidator extends ConstraintValidator
{
    public function validate($value, Constraint $constraint)
    {
        if($value instanceof Construction) {
            if($value->getData()->getPointXyGeometryCoordinates() === null &&
                $value->getPendingData()->getPointXyGeometryCoordinates() === null &&
                $value->getGeoPointAsLonLatArray() === null
            ) {
                $this->context->addViolationAt(
                    'customData.PointXyGeometryCoordinates',
                    $constraint->message
                );
            }
        }
    }
}