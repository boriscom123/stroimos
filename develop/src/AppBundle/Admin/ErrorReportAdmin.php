<?php
namespace AppBundle\Admin;

use AppBundle\Entity\ErrorReport;
use Sonata\AdminBundle\Admin\Admin;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\DoctrineORMAdminBundle\Datagrid\ProxyQuery;

class ErrorReportAdmin extends Admin
{
    protected $datagridValues = array(
        '_page' => 1,
        '_sort_order' => 'ASC',
        '_sort_by' => 'status'
    );

    public function createQuery($context = 'list')
    {
        if ('status' !== $this->getRequest()->query->get('filter._sort_by')) {
            return parent::createQuery($context);
        }

        $queryBuilder = $this->getModelManager()->getEntityManager($this->getClass())->createQueryBuilder();

        $statusOrder = $this->getRequest()->query->get('filter._sort_order');

        $queryBuilder->select('e')
            ->from($this->getClass(), 'e')
            ->orderby('e.status', $statusOrder)
            ->addOrderby('e.createdAt', 'DESC');

        return new ProxyQuery($queryBuilder);
    }

    protected function configureListFields(ListMapper $list)
    {
        $list
            ->addIdentifier('id')
            ->addIdentifier('status', 'choice', [
                'choices' => ErrorReport::$statusList,
            ])
            ->add('category', 'choice', [
                'choices' => ErrorReport::$categoryList
            ])
            ->add('createdAt')
            ->add('from', 'string', [
                'sortable' => false,
                'label' => 'Отправитель',
                'template' => ':Admin:ErrorReport/from_list_field.html.twig'
            ])
            ->add('message')
            ->add('hpsmId')
        ;
    }

    protected function configureFormFields(FormMapper $form)
    {
        $from = $this->getConfigurationPool()->getContainer()->get('templating')
            ->render(':Admin/ErrorReport:from_form_as_help.html.twig', [
                'object' => $this->getSubject()
            ]);

        $form
            ->add('status', 'choice', [
                'choices' => ErrorReport::$statusList,
            ])
            ->add('category', 'choice', [
                'choices' => ErrorReport::$categoryList,
                'help' => $from
            ])
            ->add('hpsmId', null, [
                'required' => false,
                'read_only' => true
            ])
            ->add('createdAt', 'sonata_type_datetime_picker', array(
                'label' => 'Дата создания',
                'read_only' => true,
                'required' => false,
                'dp_pick_time' => true,
                'dp_language' => 'ru',
                'dp_use_seconds' => false,
                'format' => 'dd/MM/yyyy HH:mm'
            ))
            ->add('message', 'textarea', [
                'read_only' => true
            ])
            ->add('referrer', null, ['read_only' => true, 'required' => false])
        ;
    }
}
