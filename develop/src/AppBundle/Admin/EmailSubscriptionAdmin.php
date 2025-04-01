<?php
namespace AppBundle\Admin;

use AppBundle\Entity\AdministrativeUnit;
use AppBundle\Entity\EmailSubscription;
use Sonata\AdminBundle\Admin\Admin;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;

class EmailSubscriptionAdmin extends Admin
{
    protected $datagridValues = array(
        '_sort_by' => 'updatedAt',
        '_sort_order' => 'DESC',
    );

    protected function configureDatagridFilters(DatagridMapper $filter)
    {
        $filter->add('email');
    }


    protected function configureListFields(ListMapper $list)
    {
        $list->addIdentifier('id');
        $list->addIdentifier('email', null, ['label' => 'Email']);
        $list->add('createdAt', null, ['label' => 'Создан']);
        $list->add('updatedAt', null, ['label' => 'Обновлен']);
        $list->add('confirmed', 'boolean', ['label' => 'Подтверждённый', 'editable' => true]);
    }

    protected function configureFormFields(FormMapper $form)
    {
        $form->add('email', 'email');
        $form->add(
            'administrativeUnits',
            'sonata_type_model',
            [
                'label' => 'Административные округа и районы',
                'required' => false,
                'property' => 'displayTitle',
                'class' => AdministrativeUnit::class,
                'multiple' => true,
            ]
        );
    }

    public function prePersist($object)
    {
        /** @var EmailSubscription $object */
        $object->setConfirmed(true);
    }
}
