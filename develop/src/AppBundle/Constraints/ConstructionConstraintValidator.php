<?php

namespace AppBundle\Constraints;

use AppBundle\Entity\Construction;
use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;

class ConstructionConstraintValidator extends ConstraintValidator
{
    /**
     * Checks if the passed value is valid.
     *
     * @param mixed $value The value that should be validated
     * @param Constraint $constraint The constraint for the validation
     *
     * @api
     */
    public function validate($construction, Constraint $constraint)
    {
        /** @var $construction Construction */

        if(!$construction->getData()->getObjectStatus() && !$construction->getPendingData()->getObjectStatus() &&
            !$construction->getCustomData()->getObjectStatus()){
            $this->context->buildViolation($constraint->message)
                ->atPath('customDataObjectStatus')
                ->addViolation();
        }
    }
} 