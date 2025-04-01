<?php
namespace AppBundle\Form\Type;

use AppBundle\Form\DataTransformer\GeoPointToStringTransformer;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class GeoPointType extends AbstractType
{
    public function getName()
    {
        return 'geopoint';
    }

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $transformer = new GeoPointToStringTransformer();
        $builder->addModelTransformer($transformer);
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults([
            'by_reference' => false,
        ]);

        $resolver->setDefaults([
            'map_width' => 640,
            'map_height' => 480,
        ]);
    }

    public function getParent()
    {
        return 'text';
    }
}
