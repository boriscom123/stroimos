<?php

namespace AppBundle\Form\Type;

use AppBundle\Form\DataTransformer\EntityToPropertyTransformer;
use AppBundle\Form\DataTransformer\PublicationRelationToPropertyTransformer;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\Form\FormView;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class AjaxAutocompleteType extends AbstractType
{
    private $container;

    public function __construct(ContainerInterface $container)
    {
        $this->container = $container;
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => null,
        ));

        $resolver->setDefaults(array(
            'class'             => null,
            'property'          => 'title',
            'compound'          => false
        ))
        ->addAllowedTypes(array('class' => 'string'))
        ->addAllowedTypes(array('property' => 'string'));

    }

    public function getName()
    {
        return 'ajax_autocomplete';
    }

    public function getParent()
    {
        return 'text';
    }

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->setAttribute('data_class', 'Application\Amg\DataBundle\Entity\Article');

        if (in_array(
            $options['class'],
            array(
                'Application\Amg\DataBundle\Entity\RelatedPublicationRelation',
                'Application\Amg\DataBundle\Entity\FooterPublicationRelation'
            ))
        ) {
            $builder->addViewTransformer(new PublicationRelationToPropertyTransformer(
                $this->container->get('doctrine')->getManager(),
                $options['class'],
                $options['property']
            ), true);
        } else {
            $builder->addViewTransformer(new EntityToPropertyTransformer(
                $this->container->get('doctrine')->getManager(),
                $options['class'],
                $options['property']
            ), true);
        }
    }

    public function buildView(FormView $view, FormInterface $form, array $options)
    {
        $view->vars['entity_class'] = str_replace('\\', '\\\\', $options['class']);
        $view->vars['entity_property'] = $options['property'];
    }
}
