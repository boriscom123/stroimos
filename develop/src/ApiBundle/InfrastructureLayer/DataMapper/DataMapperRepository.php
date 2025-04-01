<?php

namespace ApiBundle\InfrastructureLayer\DataMapper;

class DataMapperRepository
{
    public function __construct(array $mappers)
    {
        foreach ($mappers as $key => $mapper) {
            if (!is_callable($mapper)) {
                throw new \Exception('Unproccessable entity');
            }
            $this->items[$key] = $mapper;
        }
    }

    /**
     * @param string $factoryId
     * @return null | callable
     */
    public function find($factoryId)
    {
        if (!isset($this->items[$factoryId])) {
            return null;
        }

        return $this->items[$factoryId];
    }
}
