<?php
namespace AppBundle\Admin;

use AppBundle\Entity\Construction;
use Doctrine\ORM\EntityManager;
use Sonata\AdminBundle\Admin\Admin;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Route\RouteCollection;
use Sonata\AdminBundle\Show\ShowMapper;
use Sonata\AdminBundle\Validator\ErrorElement;
use Sonata\DoctrineORMAdminBundle\Datagrid\ProxyQuery;
use Sonata\DoctrineORMAdminBundle\Model\ModelManager;

class OrganizationAdmin extends Admin
{
    /**
     * @var EntityManager
     */
    private $em;

    protected function configureListFields(ListMapper $list)
    {
        $list->addIdentifier('title');
        $list->addIdentifier('fullTitle');
        $list->add('_action', 'actions', ['actions' => [
            'edit' => [],
            'delete' => [],
        ]]);
    }

    protected function configureFormFields(FormMapper $form)
    {
        $form->tab('Основное')->with('Контент')
            ->add('fullTitle', 'text')
            ->add('companyType', null, ['required' => false])
            ->end()->end();

        $form->tab('Контактная информация')->with('')
            ->add('legalAddress', null, ['required' => false])
            ->add('actualAddress', null, ['required' => false])
            ->add('website', 'url', ['required' => false])
            ->end()->end();

        $form->add('head', 'sonata_type_model_list', [
            'required' => false,
        ]);

        $form->add('headOrganization', 'sonata_type_model_list', [
            'required' => false,
            'btn_add' => false,
        ]);
        $form->add('lowerOrganizations', 'sonata_type_model', ['multiple' => true, 'required' => false, 'btn_add' => false]);

        $form->add('organizationDirectory', 'sonata_type_model', ['required' => false, 'btn_add' => false]);
    }

    protected function configureShowFields(ShowMapper $filter)
    {
        $filter
            ->add('fullTitle')
            ->add('companyType')
            ->add('legalAddress')
            ->add('actualAddress')
            ->add('website')
            ->add('head')
            ->add('headOrganization')
            ->add('lowerOrganizations')
            ->add('organizationDirectory')
        ;
    }

    protected function configureDatagridFilters(DatagridMapper $filter)
    {
        $filter->add('title');
    }

    protected function configureRoutes(RouteCollection $collection)
    {
        $collection->add('browse');
    }

    public function createQuery($context = 'list')
    {
        /** @var ModelManager $modelManager */
        $modelManager = $this->getModelManager();
        $repository = $modelManager->getEntityManager($this->getClass())->getRepository($this->getClass());

        $queryBuilder = $repository->createQueryBuilder('o');

        if ($this->request->get('CKEditorFuncNum')) {
            $queryBuilder->andWhere('o.publishable = true');
        }

        $proxyQuery = new ProxyQuery($queryBuilder);

        return $proxyQuery;
    }

    public function validate(ErrorElement $errorElement, $object)
    {
        $isPublishable= $this->getForm()->get('publishable')->getData();
        if ($isPublishable) {
            return;
        }

        $construction = $this->em->getRepository(Construction::class)->findOneBy(['organization' => $object]);
        if (!$construction) {
            return;
        }

        $errorElement
            ->addViolation('Снять с публикации невозможно. У организации есть опубликованные объекты строительства.');
    }

    public function setEntityManager(EntityManager $em)
    {
        $this->em = $em;
    }

}
