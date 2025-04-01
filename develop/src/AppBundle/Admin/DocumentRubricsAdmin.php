<?php
namespace AppBundle\Admin;

use Doctrine\ORM\QueryBuilder;
use Sonata\AdminBundle\Admin\Admin;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Route\RouteCollection;

class DocumentRubricsAdmin extends Admin
{
    protected $maxPerPage = 2500;
    protected $maxPageLinks = 2500;

    public function createQuery($context = 'list')
    {
        /** @var QueryBuilder $query */
        $query = parent::createQuery($context);

        $rootAliases = $query->getRootAliases();
        $rootAlias = reset($rootAliases);

        $query->orderBy($rootAlias.'.root, '.$rootAlias.'.left', 'ASC');
        return $query;
    }

    protected function configureRoutes(RouteCollection $collection)
    {
        $collection->remove('export');
        $collection->remove('show');
    }

    /**
     * @param ListMapper $listMapper
     */
    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper
            ->addIdentifier('title', null, array('sortable' => false, 'label' => 'Название рубрики', 'template' => ':Admin:raw_list_field.html.twig'))
        ;
    }

    protected function configureFormFields(FormMapper $form)
    {
        $form
            ->tab('Основное')
                ->with('Контент')
                    ->add('parent', null, array(
                        'required' => false,
                        'label' => 'Родительская рубрика'
                    ))
                ->end()
            ->end()
        ;
    }
}
