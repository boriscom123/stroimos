<?php
namespace AppBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\Form\FormView;
use Symfony\Component\OptionsResolver\OptionsResolver;

class HyperlinkType extends AbstractType
{
    public function getParent()
    {
        return 'text';
    }

    public function buildView(FormView $view, FormInterface $form, array $options)
    {
        $view->vars['text'] = $options['text'];
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefined('text');

        $resolver->setDefaults([
            'disabled' => true,
        ]);
    }

    public function getName()
    {
        return 'hyperlink';
    }
}
