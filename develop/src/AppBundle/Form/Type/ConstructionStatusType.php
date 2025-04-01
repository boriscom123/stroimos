<?php
namespace AppBundle\Form\Type;

use AppBundle\Entity\Embeddable\ConstructionStatus;
use AppBundle\Form\DataTransformer\ConstructionStatusToStringTransformer;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class ConstructionStatusType extends AbstractType
{
    public function getName()
    {
        return 'construction_status';
    }

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $transformer = new ConstructionStatusToStringTransformer();
        $builder->addModelTransformer($transformer);
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults([
            'choices' => ConstructionStatus::$labels,
        ]);
    }

    public function getParent()
    {
        return 'choice';
    }
}
