<?php
namespace AppBundle\Form\DataTransformer;

use AppBundle\Entity\Embeddable\RoadType;
use Symfony\Component\Form\DataTransformerInterface;

class RoadTypeToStringTransformer implements DataTransformerInterface
{
    public function transform($roadType)
    {
        if (null === $roadType) {
            return null;
        }

        if ($roadType instanceof RoadType) {
            return (string)$roadType;
        }

        return $roadType;
    }

    public function reverseTransform($string)
    {
        if (!$string) {
            return null;
        }

        return RoadType::create($string);
    }
}

