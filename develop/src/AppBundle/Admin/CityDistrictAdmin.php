<?php
namespace AppBundle\Admin;

use Sonata\AdminBundle\Admin\Admin;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;

class CityDistrictAdmin extends Admin
{
    protected function configureFormFields(FormMapper $form)
    {
        $form->add('parent', 'sonata_type_model', [
            'label' => 'Административный округ'
        ]);
        $form->add('title');
        $form->add('publishable',null, ['required' => false]);
        $form->add('slug', null, ['required' => false]);
        $form->add(
            'image',
            'sonata_type_model_list',
            ['required' => true],
            ['link_parameters' => ['lock_context' => ['main_image', 'gallery_media']]]
        );
        $form->add('content', 'ckeditor', array('required' => false));
        $form->add('square');
        $form->add('population');
    }

    /**
     * @inheritdoc
     */
    protected function configureDatagridFilters(DatagridMapper $filter)
    {
        $filter->add('title');
        $filter->add('publishable');
        $filter->add('parent.title', null, [
        'label' => 'Административный округ'
    ]);
    }

    protected function configureListFields(ListMapper $list)
    {
        $list->addIdentifier('title');
        $list->add('parent.title', null, [
            'label' => 'Административный округ'
        ]);
        $list->add('publishable', null, [
            'label' => 'Активность',
            'editable' => true
        ]);
    }
}
