<?php

namespace ApiBundle\InfrastructureLayer\Converter;

interface ArrayToCriteriaConverterInterface
{
    public function convert(array $criteriaAsArray, array $filedAliases = null);
}
