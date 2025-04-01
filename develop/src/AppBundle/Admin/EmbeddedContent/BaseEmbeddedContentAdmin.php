<?php

namespace AppBundle\Admin\EmbeddedContent;

use AppBundle\Entity\EmbeddedContent\BaseEmbeddedContent;
use AppBundle\Exception\ModelDeleteErrorException;
use Sonata\AdminBundle\Admin\Admin;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Route\RouteCollection;

class BaseEmbeddedContentAdmin extends Admin
{
    /**
     * @inheritdoc
     */
    protected $formOptions = array(
        'cascade_validation' => true
    );

    protected $datagridValues = [
        '_page' => 1,            // display the first page (default = 1)
        '_sort_order' => 'DESC', // reverse order (default = 'ASC')
        '_sort_by' => 'createdAt'  // name of the ordered field
    ];

    /**
     * @inheritdoc
     */
    public $supportsPreviewMode = true;

    /**
     * {@inheritdoc}
     */
    public function getPersistentParameters()
    {
        return array_merge(parent::getPersistentParameters(), array(
            'CKEditorFuncNum' => strtolower($this->getClassnameLabel())
        ));
    }

    /**
     * @inheritdoc
     */
    protected function configureRoutes(RouteCollection $collection)
    {
        $collection->add('browse');
    }

    /**
     * @inheritdoc
     */
    public function getBatchActions()
    {
        return [];
    }

    /**
     * @inheritdoc
     */
    public function preRemove($object)
    {
        if($object instanceof BaseEmbeddedContent && $object->getPages()->count() > 0) {
            throw new ModelDeleteErrorException('Невозможно удалить объект, так как он используется на страницах');
        }
    }

    /**
     * @inheritdoc
     */
    protected function configureListFields(ListMapper $list)
    {
        $list->addIdentifier('id')
            ->addIdentifier('title')
            ->addIdentifier('publishable')
            ->addIdentifier('createdAt')
            ->add('pages');
    }
}
