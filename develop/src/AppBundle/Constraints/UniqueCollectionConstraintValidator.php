<?php

namespace AppBundle\Constraints;

use Doctrine\Common\Collections\Collection;
use Symfony\Component\PropertyAccess\PropertyAccessor;
use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;

class UniqueCollectionConstraintValidator extends ConstraintValidator
{
    /**
     * Checks if the passed collection contains only unique values
     *
     * @param mixed $collection The value that should be validated
     * @param Constraint $constraint The constraint for the validation
     *
     * @api
     */
    public function validate($collection, Constraint $constraint)
    {
        if($collection instanceof Collection && $constraint instanceof UniqueCollectionConstraint) {
            $forCheck = [];
            $pa = new PropertyAccessor();
            $path = explode('.', $constraint->field);
            foreach ($collection as $item) {
                $val = $pa->getValue($item, $path[0]);
                if(isset($path[1])) {
                    $val = $pa->getValue($val, $path[1]);
                }
                $forCheck[] = $val;
            }

            $totalBefore = count($forCheck);
            if(count(array_unique($forCheck)) !== $totalBefore) {
                $this->context->buildViolation(sprintf($constraint->message, $constraint->collectionName))
                    ->addViolation();
            }
        }
    }
} 