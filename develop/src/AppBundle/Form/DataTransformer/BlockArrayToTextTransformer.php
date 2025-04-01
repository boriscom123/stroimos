<?php

namespace AppBundle\Form\DataTransformer;

use Symfony\Component\Form\DataTransformerInterface;

class BlockArrayToTextTransformer implements DataTransformerInterface
{
    public function transform($array)
    {
        if (is_array($array)){
            $array = stripslashes(json_encode($array));
        }
        return $array;
    }

    public function reverseTransform($text)
    {
        $array = json_decode($text, true);
        return $array;
    }
}
