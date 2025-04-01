<?php
namespace AppBundle\Admin;

use Sonata\AdminBundle\Admin\Admin;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Route\RouteCollection;
use Sonata\AdminBundle\Show\ShowMapper;
use Sonata\DoctrineORMAdminBundle\Datagrid\ProxyQuery;
use Sonata\DoctrineORMAdminBundle\Model\ModelManager;

class ContactPersonAdmin extends Admin
{
    protected $datagridValues = [
        '_sort_by' => 'lastName',
        '_sort_order'=> 'ASC',
    ];

    protected function configureRoutes(RouteCollection $collection)
    {
        $collection->add('browse');
    }

    protected function configureDatagridFilters(DatagridMapper $filter)
    {
        $filter->add('lastName');
    }

    protected function configureListFields(ListMapper $list)
    {
        $list->addIdentifier('fullName', 'string', ['associated_property' => 'fullName']);
        $list->add('organization.title');
        $list->add('appointment');
        $list->add('_action', 'actions', ['actions' => [
            'edit' => [],
            'delete' => [],
        ]]);
    }

    protected function configureFormFields(FormMapper $form)
    {
        $form->add('lastName', null);
        $form->add('firstName', null);
        $form->add('patronymic', null, ['required' => false]);
        $form->add('biography', 'ckeditor', ['required' => false]);
        $form->add('organization', 'sonata_type_model_list', [
            'label' => 'Организация',
            'required' => false,
            'btn_add' => false,
            'btn_delete' => false,
        ]);
        $form->add('appointment', null, ['required' => false]);
        $form->add('phone', null, ['required' => false]);
        $form->add('fax', null, ['required' => false]);
        $form->add('email', 'email', ['required' => false]);
        $form->add('weight', null,
            ['help' => 'На странице "Руководство" отображаются только контакты с весом > 0']
        );
    }

    protected function configureShowFields(ShowMapper $filter)
    {
        $filter
            ->add('lastName')
            ->add('firstName')
            ->add('patronymic')
            ->add('organization')
            ->add('appointment')
            ->add('phone')
            ->add('fax')
            ->add('email')
        ;
    }

    public function createQuery($context = 'list')
    {
        /** @var ModelManager $modelManager */
        $modelManager = $this->getModelManager();
        $repository = $modelManager->getEntityManager($this->getClass())->getRepository($this->getClass());

        $queryBuilder = $repository->createQueryBuilder('cp');

        if ($this->request->get('pcode') === 'admin.organization') {
            $queryBuilder->andWhere($queryBuilder->expr()->isNull('cp.organization'));
        }

        $proxyQuery = new ProxyQuery($queryBuilder);

        return $proxyQuery;
    }
}
