<?php

namespace ApiBundle\InfrastructureLayer\QueryFactory;

interface QueryFactoryInterface
{

    /**
     * @param array|null $filters
     * @return \IteratorAggregate | \Countable
     *
     */
    public function createQuery(array $filters = null);
}
