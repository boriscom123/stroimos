<?php
namespace AppBundle\Form\DataTransformer;

use Symfony\Component\Form\DataTransformerInterface;


class DatepickerToDatetimeTransformer implements DataTransformerInterface
{
    /**
     * @param string $date
     * @return string
     */
    public function transform($date)
    {
        if ($date) {
            $timestamp = strtotime($date);
            $output = date('d.m.Y H:i', $timestamp);
            return $output;
        }
        return $date;
    }

    /**
     * @param string $date
     * @return string
     */
    public function reverseTransform($date)
    {
        if ($date) {
            $timestamp = strtotime($date);
            $output = date('Y-m-d H:i', $timestamp);
            return $output;
        }
        return $date;
    }
}
