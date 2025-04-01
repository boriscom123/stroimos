<?php
namespace ExtraBundle\Form\Type;

use ExtraBundle\Entity\EventFeedback;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class EventFeedbackType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        if (!$builder->getData()->getUser()) {
            $builder
                ->add('fullName', null, ['required' => true, 'label' => 'ФИО'])
                ->add('email', 'email', ['required' => true, 'label' => 'Email']);
        }

        $builder
            ->add('category', 'choice', [
                'label' => 'Тип сообщения',
                'choices' => EventFeedback::$categoryList
            ])
            ->add('message', 'textarea', ['label' => 'Сообщение'])
            ->add('save', 'submit', ['label' => 'Отправить сообщение'])
        ;
    }

    public function getName()
    {
        return 'event_feedback';
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults([
            'data_class' => 'ExtraBundle\Entity\EventFeedback',
        ]);
    }
}
