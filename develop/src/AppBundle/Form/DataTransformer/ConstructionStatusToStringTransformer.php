<?php
namespace AppBundle\Form\DataTransformer;

use AppBundle\Entity\Embeddable\ConstructionStatus;
use Symfony\Component\Form\DataTransformerInterface;

class ConstructionStatusToStringTransformer implements DataTransformerInterface
{
    public function transform($constructionStatus)
    {
        if (null === $constructionStatus) {
            return null;
        }

        if ($constructionStatus instanceof ConstructionStatus) {
            return (string)$constructionStatus;
        }

        return $constructionStatus;
    }

    public function reverseTransform($string)
    {
        if (!$string) {
            return null;
        }

        return ConstructionStatus::create($string);
    }
}

