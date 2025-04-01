<?php

namespace AppBundle\Twig;

class DistanceTwigExtension extends \Twig_Extension
{
    public function getFilters()
    {
        return array(
            'distance_format' => new \Twig_Filter_Method($this, 'distanceFormat')
        );
    }

    public function distanceFormat($distance, $kilometer = ' км ', $meter = ' м ')
    {
        $km = $distance % 1000;
        $km = $km ? "{$km}{$kilometer}" : '';

        $m = round(($distance - $km) * 1000);
        $m = $m ? "{$m}{$meter}" : '';

        return trim($km . $m);
    }

    public function getName()
    {
        return 'distance';
    }
}
