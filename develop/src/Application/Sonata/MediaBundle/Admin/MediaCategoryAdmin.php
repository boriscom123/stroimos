<?php

namespace Application\Sonata\MediaBundle\Admin;

use Amg\Bundle\PageBundle\Layout\LayoutManager;
use AppBundle\Entity\MediaCategory;
use Doctrine\ORM\QueryBuilder;
use Sonata\AdminBundle\Admin\Admin;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Route\RouteCollection;

class MediaCategoryAdmin extends Admin
{
    protected $maxPerPage = 2500;

    protected $maxPageLinks = 2500;

    /**
     * @var LayoutManager
     */
    protected $layoutManager;

    public function createQuery($context = 'list')
    {
        /** @var QueryBuilder $query */
        $query = parent::createQuery($context);

        $rootAliases = $query->getRootAliases();
        $rootAlias = reset($rootAliases);

        $query->orderBy($rootAlias . '.root, ' . $rootAlias . '.lft', 'ASC');

        return $query;
    }

    public function hasRoute($name)
    {
        if ('delete' === $name) {
            $subject = $this->getSubject();
            if (is_object($subject) && !$subject->getChildren()->isEmpty()) {
                return false;
            }
        }

        return parent::hasRoute($name);
    }

    protected function configureRoutes(RouteCollection $collection)
    {
        $collection->add('move', $this->getRouterIdParameter() . '/move/{direction}');
    }

/*    public function generateObjectUrl($name, $object, array $parameters = array(), $absolute = false)
    {
        $parameters['id'] = $this->getUrlsafeIdentifier($object);

        return $this->generateUrl($name, $parameters, $absolute);
    }*/

    /**
     * @param ListMapper $listMapper
     */
    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper
            ->addIdentifier('title', null, [
                'sortable' => false,
                'label' => 'Название',
                'template' => 'AmgPageBundle:Admin:raw_list_field.html.twig',
            ])
            ->add('_action', 'actions', ['actions' => [
                'move' => ['template' => 'AmgPageBundle:Admin:_move.html.twig'],
                'edit' => [],
            ]]);
        ;
    }

    /**
     * @param FormMapper $form
     */
    protected function configureFormFields(FormMapper $form)
    {
        $requiredParent = !(bool) $this->getConfigurationPool()->getContainer()->get('doctrine')
            ->getRepository(MediaCategory::class)
            ->createQueryBuilder('mc')
            ->select('COUNT(mc)')
            ->getQuery()
            ->getOneOrNullResult();

        $form
            ->add('title', null, ['label' => 'Название'])
            ->add('parent', 'media_category_tree', array(
                'class' => $this->getClass(),
                'required' => $requiredParent,
                'label' => 'Родительская категория'
            ))
        ;
    }
}
