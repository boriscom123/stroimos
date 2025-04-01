<?php
namespace AppBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class AddressType extends AbstractType
{
    public function getName()
    {
        return 'address';
    }

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('text', 'text');
        $builder->add('geoPoint', 'geopoint');
        if ($options['polygon']) {
            $builder->add('geoPolygon', 'hidden');
        }
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults([
            'data_class' => 'AppBundle\Entity\Embeddable\Address',
            'compound' => true,
            'polygon' => false,
        ]);
    }
}
