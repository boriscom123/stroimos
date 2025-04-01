<?php

namespace AppBundle\Admin\Newsletter;

use Sonata\AdminBundle\Form\FormMapper;

class GalleryNewsletterAdmin extends BaseNewsletterItemAdmin
{
    /**
     * @inheritdoc
     */
    protected function configureFormFields(FormMapper $formMapper)
    {
        $formMapper->add('gallery', 'sonata_type_model_autocomplete', [
            'property' => 'title',
            'multiple' => false,
            'required' => true
        ]);

        parent::configureFormFields($formMapper);
    }
}
