<?php
namespace AppBundle\Form\Type;

use AppBundle\Entity\ErrorReport;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class ErrorReportType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        if (!$builder->getData()->getUser()) {
            $builder
                //->add('fullName', null, ['required' => true, 'label' => 'ФИО'])
                ->add('email', 'email', ['required' => true, 'label' => 'Email']);
        }

        $builder
            ->add('category', 'choice', [
                'label' => 'Категория',
                'choices' => ErrorReport::$categoryList
            ])
            ->add('message', 'textarea', ['label' => 'Сообщение'])
            ->add('referrer', 'hidden')
            ->add('captcha', 're_captcha', [
                'type' => 'checkbox' // (invisible, checkbox)
            ])
            ->add('save', 'submit', ['label' => 'Отправить сообщение'])
        ;
    }

    public function getName()
    {
        return 'error_report';
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults([
            'data_class' => 'AppBundle\Entity\ErrorReport',
        ]);
    }
}
