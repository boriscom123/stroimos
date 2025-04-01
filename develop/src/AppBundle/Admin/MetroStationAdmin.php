<?php
namespace AppBundle\Admin;

use AppBundle\Admin\Form\PrivateUrlTrait;
use AppBundle\Entity\MetroStation;
use Sonata\AdminBundle\Admin\Admin;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;

class MetroStationAdmin extends Admin
{
    use PrivateUrlTrait;

    public $supportsPreviewMode = true;

    /**
     * @param MetroStation $object
     *
     * @return void
     */
    public function prePersist($object)
    {
        $this->save($object);
    }

    /**
     * @param MetroStation $object
     *
     * @return void
     */
    public function preUpdate($object)
    {
        $this->save($object);
    }

    protected function configureFormFields(FormMapper $form)
    {
        $form->tab('Основное')->with('Параметры');
        $this->addPrivateUrl($this, $form);
        $form->end()->end();

        $form->add('line', 'sonata_type_model');
        $form->add('constructionStatus', 'construction_status');
        $form->add('constructionStatusDescription');
        $form->add('constructionStartYear');
        $form->add('constructionEndYear');
        $form->add('entranceHallDescription');
        $form->add('featureDescription');
        $form->add('capacityDescription');
        $form->add('video', 'sonata_type_model_list', [], ['link_parameters' => ['context' => 'video', 'lock_context' => true]]);
        $form->add('medias', 'sonata_type_collection', [
            'label' => false,
            'required' => false,
        ], [
            'edit' => 'inline',
            'inline' => 'table',
            'sortable' => 'position',
        ]);
        $form->add('x', null, ['label' => 'Отступ от центра по X'])
            ->add('y', null, ['label' => 'Отступ от центра по Y']);

        if (!$form->has('relatedGalleries')) {
            $form->add('relatedGalleries', 'sonata_type_model_autocomplete', array(
                'label' => 'Галереи',
                'property' => 'title',
                'multiple' => true,
                'attr' => array('style' => 'width: 100%'),
                'required' => false
            ));
        }
    }

    protected function configureListFields(ListMapper $list)
    {
        $list->addIdentifier('title');
        $list->add('line');
    }

    protected function configureDatagridFilters(DatagridMapper $filter)
    {
        $filter->add('line');
        $filter->add('title');
    }

    /**
     * @param MetroStation $object
     *
     * @return void
     */
    private function save($object)
    {
        foreach ($object->getMedias() as $image) {
            $image->setMetroStation($object);
        }
    }
}
