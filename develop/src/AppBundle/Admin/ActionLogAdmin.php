<?php
namespace AppBundle\Admin;

use AppBundle\Entity\ActionLog;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\Query;
use Sonata\AdminBundle\Admin\Admin;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Route\RouteCollection;

class ActionLogAdmin extends Admin
{
    protected $datagridValues = [
        '_sort_by' => 'date',
        '_sort_order'=> 'desc',
    ];

    /**
     * @var EntityManager
     */
    private $em;

    protected function configureDatagridFilters(DatagridMapper $filter)
    {
        $modules = $this->em->getRepository('AppBundle:ActionLog')->createQueryBuilder('a')
            ->select('a.module')
            ->groupBy('a.module')
            ->getQuery()
            ->getArrayResult()
        ;

        $moduleList = array();

        foreach ($modules as $module) {
            $moduleList[reset($module)] = reset($module);
        }


        $filter
            ->add('date', 'date_range_filter', array('label' => 'Дата'), 'date_range')
            ->add('user')
            ->add('ip')
            ->add('module', 'doctrine_orm_callback', array(
                'label' => 'Модуль',
                'callback' => function ($queryBuilder, $alias, $field, $value) {
                    if (!$value['value']) {
                        return null;
                    }
                    $queryBuilder
                        ->andWhere("$alias.module = :module")
                        ->setParameter('module', $value['value'])
                    ;
                    return true;
                },
                'field_type' => 'choice',
                'field_options' => array('choices' => $moduleList))
            )
            ->add('action', 'doctrine_orm_callback', array(
                    'label' => 'Действие',
                    'callback' => function ($queryBuilder, $alias, $field, $value) {
                        if (!$value['value']) {
                            return null;
                        }
                        $queryBuilder
                            ->andWhere("$alias.action = :action")
                            ->setParameter('action', $value['value'])
                        ;
                        return true;
                    },
                    'field_type' => 'choice',
                    'field_options' => array('choices' => ActionLog::$actionsLabels))
            )
            ->add('title', null, [
                'label' => 'Объект'
            ])
        ;
    }

    protected function configureRoutes(RouteCollection $collection)
    {
        $collection->remove('export');
        $collection->remove('show');
        $collection->remove('edit');
        $collection->remove('delete');
    }

    protected function configureListFields(ListMapper $list)
    {
        $list
            ->add('date')
            ->add('user')
            ->add('ip')
            ->add('module')
            ->add('action', 'choice', [
                'choices' => ActionLog::$actionsLabels
            ])
            ->add('title', 'html', [
                'label' => 'Объект'
            ])
        ;
    }

    public function setEntityManager(EntityManager $em)
    {
        $this->em = $em;
    }
}
