<?php
namespace Amg\Bundle\TagBundle\Admin;

use Sonata\AdminBundle\Admin\Admin;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;

class TagAdmin extends Admin
{
    protected function configureDatagridFilters(DatagridMapper $filter)
    {
        $filter->add('title', null, ['label' => 'Заголовок']);
    }

    protected function configureListFields(ListMapper $list)
    {
        $list
            ->addIdentifier('title', null, ['label' => 'Заголовок'])
            ->add('id', 'integer', [
                'sortable' => false,
                'label' => 'Статистика использования',
                'template' => 'AmgTagBundle:Admin:usage_count_list_field.html.twig'
            ])
        ;
    }

    public function getBatchActions()
    {
        $actions = parent::getBatchActions();

        if (
            $this->hasRoute('edit') && $this->isGranted('EDIT') &&
            $this->hasRoute('delete') && $this->isGranted('DELETE')
        ) {
            $actions['merge'] = array(
                'label' => 'Объеденить',
                'ask_confirmation' => true
            );

        }

        return $actions;
    }
}
