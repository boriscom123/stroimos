<?php
namespace AppBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\OptionsResolver\OptionsResolver;

class CollectionListType extends AbstractType
{
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'multiple' => true,
            'disabled' => true,
            'required' => false
        ]);
    }

    public function getName()
    {
        return 'collection_list';
    }

    public function getParent()
    {
        return 'entity';
    }
}
