<?php
namespace AppBundle\Admin;

use AppBundle\Entity\Document;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Form\FormMapper;

class DecisionDocumentAdmin extends DocumentBaseAdmin
{
    public $associationadmin = false;

    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $datagridMapper
            ->add('title')
            ->add('number')
            ->add('createdAt', 'date_range_filter', ['label' => 'Дата создания'], 'date_range')
            ;
    }

    protected function configureFormFields(FormMapper $form)
    {
        $form
            ->tab('Основное')
                ->with('Контент')
                    ->add('files', 'sonata_type_collection', array(
                        'cascade_validation' => false,
                        'type_options' => array('delete' => true),
                        'required' => false,
                        'label' => 'Файлы'
                    ), array(
                        'edit' => 'inline',
                        'inline' => 'table',
                        'sortable' => 'position',
                    ))
                ->end()
                ->with('Параметры')
                    ->add('number', null, array('label' => 'Номер документа'))
                    ->add('status', 'choice', array(
                        'required' => true,
                        'label' => 'Статус',
                        'choices' => array(
                            '1' => 'Действующий',
                            '0' => 'Недействующий',
                        ),
                    ))
                    ->add('approveDate', 'sonata_type_date_picker', array(
                        'label' => 'Дата утверждения',
                        'required' => true,
                        'dp_language' => 'ru',
                        'format' => 'dd/MM/yyyy'
                    ))
                ->end()
            ->end()
        ;
    }

    public function prePersist($object)
    {
        $this->save($object);
    }

    public function preUpdate($object)
    {
        $this->save($object);
    }

    /**
     * @param Document $object
     */
    protected function save($object)
    {
        foreach ($object->getFiles() as $file) {
            if ($file->getTitle() && $file->getFile()) {
                $file->setDocument($object);
            }
        }
    }
}
