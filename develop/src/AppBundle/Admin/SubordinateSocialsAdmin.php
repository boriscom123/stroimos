<?php
namespace AppBundle\Admin;

use AppBundle\Entity\SubordinateSocials;
use Sonata\AdminBundle\Admin\Admin;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;

class SubordinateSocialsAdmin extends Admin
{
    protected function configureListFields(ListMapper $list)
    {
        $list
            ->addIdentifier('id', null, ['label' => 'ID'])
            ->add('type')
            ->add('url')
        ;
    }

    protected function configureFormFields(FormMapper $form)
    {
        $form->add('type', 'choice', [
            'required' => true,
            'choices' => SubordinateSocials::$types
        ])
            ->add('url', null, ['required' => true])
            ->add('publishable', null, ['required' => false])
            ->add('weight');
    }
}
