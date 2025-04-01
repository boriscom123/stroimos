<?php
namespace AppBundle\Admin;

use AppBundle\Entity\Document;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;

class DocumentBaseAdmin extends BaseAdmin
{
    public $supportsPreviewMode = true;

    protected $formOptions = array(
        'cascade_validation' => true
    );

    protected $datagridValues = [
        '_sort_by' => 'createdAt',
        '_sort_order' => 'DESC',
    ];

    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $datagridMapper
            ->add('title')
            ->add('createdAt', 'date_range_filter', ['label' => 'Дата создания'], 'date_range')
       ;

        $this->addOwnerDatagridFilter($datagridMapper);
    }

    protected function configureListFields(ListMapper $list)
    {
        $list->addIdentifier('id');
        $list->addIdentifier('title');
        $list->addIdentifier('createdAt');
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
                        'label' => 'Файлы',
                        'by_reference' => false
                    ), array(
                        'edit' => 'inline',
                        'inline' => 'table',
                        'sortable' => 'position',
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
            $file->setDocument($object);
        }
    }

    public function getTemplate($name)
    {
        if ('preview' === $name) {
            return ':Document:preview.html.twig';
        }

        return parent::getTemplate($name);
    }
}
