<?php

namespace ApiBundle\InfrastructureLayer\QueryFactory;

interface QueryFactoryRepositoryInterface
{
    /**
     * @param string $factoryId
     * @return null | QueryFactoryInterface
     */
    public function find($factoryId);
}
