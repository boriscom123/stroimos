<?php

namespace AppBundle\Admin;

use AppBundle\Admin\Form\PrivateUrlTrait;
use AppBundle\Constraints\UniqueCollectionConstraint;
use AppBundle\Entity\Embeddable\ConstructionStatus;
use AppBundle\Entity\Embeddable\RoadType;
use Doctrine\ORM\QueryBuilder;
use Sonata\AdminBundle\Admin\Admin;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\DoctrineORMAdminBundle\Datagrid\ProxyQuery;

class RoadAdmin extends Admin
{
    use PrivateUrlTrait;

    public $supportsPreviewMode = true;

    protected function configureDatagridFilters(DatagridMapper $filter)
    {
        $filter->add('title')
            ->add(
                'customDataObjectStatus',
                'doctrine_orm_callback',
                [
                    'callback' => [$this, 'applyFilterByObjectStatus'],
                    'field_type' => 'choice',
                    'field_options' => [
                        'choices' => ConstructionStatus::$labels,
                    ],
                ]
            )
            ->add(
                'roadType',
                'doctrine_orm_callback',
                [
                    'callback' => [$this, 'applyFilterByRoadType'],
                    'field_type' => 'choice',
                    'field_options' => [
                        'choices' => RoadType::$labels,
                    ],
                ]
            )
        ;
    }

    protected function configureListFields(ListMapper $list)
    {
        $list->addIdentifier('title');
    }

    public function configure()
    {
        $this->setTemplate('edit', ':Admin:Construction/edit.html.twig');
    }


    protected function configureFormFields(FormMapper $form)
    {
        $form->tab('Основное')->with('Параметры');
        $this->addPrivateUrl($this, $form);
        $form->end()->end();

        $form->add('roadType', 'road_type');
        $form->add('constructionStatus', 'construction_status');
        $form->add('constructionStatusDescription');
        $form->add('constructionStartYear');
        $form->add('constructionEndYear');
        $form->add(
            'roadParameterValues',
            'sonata_type_collection',
            [
                'required' => false,
                'by_reference' => false,
                'constraints' => [
                    new UniqueCollectionConstraint(
                        [
                            'collectionName' => 'Значения характеристик',
                            'field' => 'constructionParameter.id',
                        ]
                    ),
                ],
            ],
            [
                'edit' => 'inline',
                'inline' => 'table',
            ]
        );
    }

    /**
     * @param ProxyQuery $qb
     * @param $alias
     * @param $field
     * @param $value
     * @return bool|void
     */
    public function applyFilterByObjectStatus(ProxyQuery $qb, $alias, $field, $value)
    {
        if (!$value['value']) {
            return;
        }
        /** @var QueryBuilder $qb */
        $qb->andWhere(
            $qb->expr()->eq("{$alias}.constructionStatus.value", "'{$value['value']}'")
        );

        return true;
    }
    /**
     * @param ProxyQuery $qb
     * @param $alias
     * @param $field
     * @param $value
     * @return bool|void
     */
    public function applyFilterByRoadType(ProxyQuery $qb, $alias, $field, $value)
    {
        if (!$value['value']) {
            return;
        }
        /** @var QueryBuilder $qb */
        $qb->andWhere(
            $qb->expr()->eq("{$alias}.roadType.value", "'{$value['value']}'")
        );

        return true;
    }

}
