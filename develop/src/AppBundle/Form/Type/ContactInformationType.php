<?php

namespace AppBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class ContactInformationType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('lastName', null, ['label' => 'Фамилия']);
        $builder->add('firstName', null, ['label' => 'Имя']);
        $builder->add('patronymic', null, ['label' => 'Отчество']);
        $builder->add('appointment', null, ['label' => 'Должность']);
        $builder->add('phone', null, ['label' => 'Телефон']);
        $builder->add('fax', null, ['label' => 'Факс']);
        $builder->add('email', 'email', ['label' => 'Email']);
    }

    public function getName()
    {
        return 'contact_information';
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults([
            'data_class' => 'AppBundle\Entity\ContactInformation',
        ]);
    }
}
