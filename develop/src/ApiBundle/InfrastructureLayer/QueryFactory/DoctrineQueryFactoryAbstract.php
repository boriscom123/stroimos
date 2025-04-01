<?php

namespace ApiBundle\InfrastructureLayer\QueryFactory;

use ApiBundle\InfrastructureLayer\Converter\ArrayToCriteriaConverterInterface;
use Doctrine\ORM\EntityManagerInterface;

abstract class DoctrineQueryFactoryAbstract implements QueryFactoryInterface
{
    /**
     * @var \Doctrine\ORM\QueryBuilder
     */
    protected $queryBuilder;

    /**
     * @var ArrayToCriteriaConverterInterface
     */
    protected $converter;
    /**
     * @var EntityManagerInterface
     */
    protected $entityManager;

    public function __construct(
        EntityManagerInterface $entityManager,
        ArrayToCriteriaConverterInterface $converter
    ) {
        $this->queryBuilder = $entityManager->createQueryBuilder();
        $this->converter = $converter;
        $this->entityManager = $entityManager;
    }
}
