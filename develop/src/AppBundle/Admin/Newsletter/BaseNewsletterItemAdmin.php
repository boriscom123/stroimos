<?php
namespace AppBundle\Admin\Newsletter;

use Sonata\AdminBundle\Admin\Admin;
use Sonata\AdminBundle\Form\FormMapper;

class BaseNewsletterItemAdmin extends Admin
{
    /**
     * @inheritdoc
     */
    protected function configureFormFields(FormMapper $formMapper)
    {
        $formMapper->add('priorityPosition', 'hidden');
    }
}
