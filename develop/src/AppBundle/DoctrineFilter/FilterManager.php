<?php

namespace AppBundle\DoctrineFilter;


use Doctrine\ORM\EntityManager;
use Doctrine\ORM\Query\FilterCollection;

class FilterManager
{
    /**
     * @var EntityManager
     */
    private $entityManager;

    public function __construct(EntityManager $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    /**
     * @return FilterCollection
     */
    protected function getFilterCollection()
    {
        return $this->entityManager->getFilters();
    }

    /**
     * @param $filterName
     * @return $this
     */
    public function disable($filterName)
    {
        $filterCollection = $this->getFilterCollection();

        if ($filterCollection->isEnabled($filterName)) {
            $filterCollection->disable($filterName);
        }

        return $this;
    }

    /**
     * @param $filterName
     * @return $this
     */
    public function enable($filterName)
    {
        $filterCollection = $this->getFilterCollection();

        if (!$filterCollection->isEnabled($filterName)) {
            $filterCollection->enable($filterName);
        }

        return $this;
    }
}