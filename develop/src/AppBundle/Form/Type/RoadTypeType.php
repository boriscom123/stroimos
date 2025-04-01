<?php
namespace AppBundle\Form\Type;

use AppBundle\Entity\Embeddable\RoadType;
use AppBundle\Form\DataTransformer\RoadTypeToStringTransformer;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class RoadTypeType extends AbstractType
{
    public function getName()
    {
        return 'road_type';
    }

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $transformer = new RoadTypeToStringTransformer();
        $builder->addModelTransformer($transformer);
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults([
            'choices' => RoadType::$labels,
        ]);
    }

    public function getParent()
    {
        return 'choice';
    }
}
