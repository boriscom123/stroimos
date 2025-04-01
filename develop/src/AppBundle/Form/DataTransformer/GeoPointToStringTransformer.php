<?php
namespace AppBundle\Form\DataTransformer;

use AppBundle\Model\ValueObject\GeoPoint;
use Symfony\Component\Form\DataTransformerInterface;

class GeoPointToStringTransformer implements DataTransformerInterface
{
    public function transform($geoPoint)
    {
        if (null === $geoPoint) {
            return null;
        }

        if ($geoPoint instanceof GeoPoint) {
            return $geoPoint->getLonLatString();
        }

        return $geoPoint;
    }

    public function reverseTransform($string)
    {
        if (!$string) {
            return null;
        }

        return GeoPoint::createFromLonLatString($string);
    }
}

