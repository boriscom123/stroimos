<?php

namespace AppBundle\Admin\Newsletter;

use Sonata\AdminBundle\Form\FormMapper;

class InfographicsNewsletterAdmin extends BaseNewsletterItemAdmin
{
    /**
     * @inheritdoc
     */
    protected function configureFormFields(FormMapper $formMapper)
    {
        $formMapper->add('infographics', 'sonata_type_model_autocomplete', [
            'property' => 'title',
            'multiple' => false,
            'required' => true
        ]);

        parent::configureFormFields($formMapper);
    }
}
