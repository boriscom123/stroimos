<?php
namespace AppBundle\Admin;

use Sonata\AdminBundle\Admin\Admin;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Route\RouteCollection;

class AnnouncementAdmin extends Admin
{
	protected $datagridValues = [
		'_sort_by' => 'publishStartDate',
		'_sort_order' => 'DESC',
	];

	protected function configureFormFields(FormMapper $form)
	{
		$form
			->tab('Основное')
				->with('Контент')
					->add('date', 'sonata_type_datetime_picker', array(
						'required' => false,
						'dp_pick_time' => true,
						'dp_language' => 'ru',
						'dp_use_seconds' => false,
						'format' => 'dd/MM/yyyy HH:mm'
					))
					->add(
						'image',
						'sonata_type_model_list',
						['required' => false],
						['link_parameters' => ['lock_context' => ['main_image', 'gallery_media']]]
					)
				->end()
				->with('Анонс')
					->add('post', 'sonata_type_model_autocomplete', array(
						'required' => true,
						'property' => 'title',
						'multiple' => false,
						'attr' => array('style' => 'width: 100%')
					))
				->end()
			->end();
	}

	protected function configureListFields(ListMapper $list)
	{
		$list
			->addIdentifier('title')
            ->addIdentifier('publishStartDate')
            ->addIdentifier('publishable', null, [
                'label' => 'Опубликовано',
                'template' => ':Admin:Announcement/list_field_publishable.html.twig',
            ])
            ->addIdentifier('publishEndDate')
		;
	}

	protected function configureRoutes(RouteCollection $collection)
    {
        parent::configureRoutes($collection);
        $collection
            ->add("togglePublishable", $this->getRouterIdParameter().'/togglePublishable')
        ;
    }
}
