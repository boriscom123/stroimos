<?php

namespace AppBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\Form\FormView;

class CopyContentButton extends AbstractType
{
    public function getName()
    {
        return 'copy_content_button';
    }

    public function buildView(FormView $view, FormInterface $form, array $options)
    {
        $view->vars['config'] = $options['config'];
    }

    public function getParent()
    {
        return 'ckeditor';
    }
}
