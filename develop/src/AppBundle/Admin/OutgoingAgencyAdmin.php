<?php
namespace AppBundle\Admin;

use Sonata\AdminBundle\Admin\Admin;
use Sonata\AdminBundle\Datagrid\ListMapper;

class OutgoingAgencyAdmin extends Admin
{
    protected function configureListFields(ListMapper $list)
    {
        $list->addIdentifier('id');
        $list->addIdentifier('title');
    }
}
