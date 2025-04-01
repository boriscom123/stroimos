<?php
namespace AppBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\Form\FormView;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class AdministrativeUnitChoiceType extends AbstractType
{
    public function getName()
    {
        return 'administrative_unit_choice';
    }

    public function buildView(FormView $view, FormInterface $form, array $options)
    {
        $view->vars['source_data_provider'] = $options['source_data_provider']();
        $view->vars['values'] = $options['values_provider']();
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        /** @var OptionsResolver $resolver */
        $resolver->setDefined(
            [
                'source_data_provider',
                'values_provider'
            ]
        );
    }
}
