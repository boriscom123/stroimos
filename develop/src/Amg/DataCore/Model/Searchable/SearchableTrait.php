<?php

namespace Amg\DataCore\Model\Searchable;

trait SearchableTrait
{
    /**
     * @var boolean
     *
     * @Doctrine\ORM\Mapping\Column(type="boolean")
     */
    protected $searchable = true;

    /**
     * @param boolean $searchable
     * @return $this
     */
    public function setSearchable($searchable)
    {
        $this->searchable = $searchable;

        return $this;
    }

    /**
     * @return boolean
     */
    public function isSearchable()
    {
        return $this->searchable;
    }
}
