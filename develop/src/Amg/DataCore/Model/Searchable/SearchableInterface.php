<?php

namespace Amg\DataCore\Model\Searchable;


interface SearchableInterface
{
    /**
     * @return boolean
     */
    public function isSearchable();

    /**
     * @param boolean $searchable
     * @return $this
     */
    public function setSearchable($searchable);
}
