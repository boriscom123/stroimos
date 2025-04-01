<?php

namespace ApiBundle\InfrastructureLayer\QueryFactory;

class QueryFactoryRepository implements QueryFactoryRepositoryInterface
{
    /**
     * @var QueryFactoryInterface[]
     */
    protected $items;

    public function __construct(array $factoryCollection = null)
    {
        foreach ($factoryCollection as $key => $factory) {
            if (!($factory instanceof QueryFactoryInterface)) {
                throw new \Exception('Unproccessable entity');
            }
            $this->items[$key] = $factory;
        }
    }


    /**
     * @param string $factoryId
     * @return null | QueryFactoryInterface
     */
    public function find($factoryId)
    {
        if (!isset($this->items[$factoryId])) {
            return null;
        }

        return $this->items[$factoryId];
    }
}
