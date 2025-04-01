<?php

namespace Amg\Bundle\FormBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\Form\FormView;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class ElFinderType extends AbstractType
{
    private $exist = false;

    /**
     * {@inheritdoc}
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver
            ->setDefaults(
                array(
                    'compound' => false,
                    'required' => false,
                    'doc_type' => 'image'
                )
            )
            ->addAllowedTypes(array('doc_type' => 'string'));
    }

    /**
     * {@inheritdoc}
     */
    public function buildView(FormView $view, FormInterface $form, array $options)
    {
        $view->vars['exist'] = $this->exist;
        $this->exist = $this->exist ?: true;

        $view->vars['doc_type'] = $options['doc_type'];
    }

    /**
     * {@inheritdoc}
     */
    public function getParent()
    {
        return 'text';
    }

    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return 'elfinder';
    }
}
