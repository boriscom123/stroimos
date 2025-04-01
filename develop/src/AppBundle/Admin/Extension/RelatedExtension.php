<?php
namespace AppBundle\Admin\Extension;

use Sonata\AdminBundle\Admin\AdminExtension;
use Sonata\AdminBundle\Form\FormMapper;

class RelatedExtension extends AdminExtension
{
    public function configureFormFields(FormMapper $form)
    {
        if (!$form->has('relatedPosts')) {
            $form->add('relatedPosts', 'sonata_type_model_autocomplete', array(
                'label' => 'Публикации',
                'property' => 'title',
                'multiple' => true,
                'attr' => array('style' => 'width: 100%'),
                'required' => false
            ));
        }

        if (!$form->has('relatedInfographics')) {
            $form->add('relatedInfographics', 'sonata_type_model_autocomplete', array(
                'label' => 'Инфографика',
                'property' => 'title',
                'multiple' => true,
                'attr' => array('style' => 'width: 100%'),
                'required' => false
            ));
        }

        if (!$form->has('relatedGalleries')) {
            $form->add('relatedGalleries', 'sonata_type_model_autocomplete', array(
                'label' => 'Галереи',
                'property' => 'title',
                'multiple' => true,
                'attr' => array('style' => 'width: 100%'),
                'required' => false
            ));
        }

        if (!$form->has('relatedVideos')) {
            $form->add('relatedVideos', 'sonata_type_model_autocomplete', array(
                'label' => 'Видео',
                'property' => 'title',
                'multiple' => true,
                'attr' => array('style' => 'width: 100%'),
                'required' => false
            ));
        }

        if (!$form->has('relatedConstructions')) {
            $form->add('relatedConstructions', 'sonata_type_model_autocomplete', array(
                'label' => 'Объекты строительства',
                'property' => ['objectName', 'objectAddress'],
                'multiple' => true,
                'attr' => array('style' => 'width: 100%'),
                'required' => false,
                'minimum_input_length' => 1
            ));
        }

        if (!$form->has('relatedMetroStations')) {
            $form->add('relatedMetroStations', 'sonata_type_model_autocomplete', array(
                'label' => 'Станции метро',
                'property' => 'title',
                'multiple' => true,
                'attr' => array('style' => 'width: 100%'),
                'required' => false,
                'minimum_input_length' => 1
            ));
        }

        if (!$form->has('relatedRoads')) {
            $form->add('relatedRoads', 'sonata_type_model_autocomplete', array(
                'label' => 'Дорожные объекты',
                'property' => 'title',
                'multiple' => true,
                'attr' => array('style' => 'width: 100%'),
                'required' => false,
                'minimum_input_length' => 1
            ));
        }

        if (!$form->has('relatedDocuments')) {
            $form->add('relatedDocuments', 'sonata_type_model_autocomplete', array(
                'label' => 'Документы',
                'property' => 'title',
                'multiple' => true,
                'attr' => array('style' => 'width: 100%'),
                'required' => false
            ));
        }
    }
}
