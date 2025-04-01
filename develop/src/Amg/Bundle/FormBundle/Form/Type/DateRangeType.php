<?php

namespace Amg\Bundle\FormBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Symfony\Component\Translation\TranslatorInterface;

class DateRangeType extends AbstractType
{
    protected $translator;

    /**
     * @param \Symfony\Component\Translation\TranslatorInterface $translator
     */
    public function __construct(TranslatorInterface $translator)
    {
        $this->translator = $translator;
    }

    /**
     * {@inheritDoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add(
            $builder->create('start', 'sonata_type_date_picker', array(
                    'label' => 'c',
                    'required' => false,
                    'dp_pick_time' => true,
                    'dp_language' => 'ru',
//                    'dp_use_seconds' => false,
                    'format' => 'dd/MM/yyyy'
                )

            ));
        $builder->add(
            $builder->create('end', 'sonata_type_date_picker', array(
                    'label' => 'по',
                    'required' => false,
                    'dp_pick_time' => true,
                    'dp_language' => 'ru',
//                    'dp_use_seconds' => false,
                    'format' => 'dd/MM/yyyy'
                )
            ));
    }

    /**
     * {@inheritDoc}
     */
    public function getName()
    {
        return 'date_range';
    }

    /**
     * {@inheritDoc}
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'field_options' => array(),
            'field_type' => 'date'
        ));
    }
}
